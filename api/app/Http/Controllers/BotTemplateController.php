<?php

namespace App\Http\Controllers;
use App\BotTemplate as Template;
use App\Http\Controllers\GoogleSheetController;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BotTemplateController extends APIController
{
    function __construct(){
        $this->model = new Template();
    }
    public function save(Request $request) {
        $req = json_decode($request['content']);
        $image = '';
        for($i = 0; $i < count($req->data); $i++){
            if($req->data[$i]->type == 'products'){
                for($x = 0; $x < count($req->data[$i]->data->reply); $x++){
                    if($request[$req->data[$i]->data->reply[$x]->image]) {
                        $file = $request[$req->data[$i]->data->reply[$x]->image];
                        $date = Carbon::now()->toDateString();
                        $time = str_replace(':', '_', Carbon::now()->toTimeString());
                        $name = time().'.'.$file->getClientOriginalExtension();
                        $file_url = str_replace(' ', '_', $file->getClientOriginalName());
                        $file_url = str_replace('%20', '_', $file_url);
                        $file_name = $request->account_id.'_'.$date.'_'.$time.'_'.$file_url;
                        $file->storeAs('images', $file_name);
                        $url = '/storage/image/'.$file_name;
                        $image = $url;
                    }
                    $req->data[$i]->data->reply[$x]->image = $image;
                }
            }
            if($req->data[$i]->type == 'form'){
                $sheet_id = $req->data[$i]->data->sheet_id;
                $last_range = count($req->data[$i]->data->fields);
                $values = [];
                $googleSheet = new GoogleSheetController($sheet_id, 'A2:' . chr(($last_range + 1) + 96) . '2');
                for($x = 0; $x < count($req->data[$i]->data->fields); $x++){
                    array_push($values, $req->data[$i]->data->fields[$x]->value);
                }
                array_push($values, 'Date');
                $_return = $googleSheet->update($values);
            }
        }
        try{
            // \DB::table('bot_templates')->insert(
            //     ['account_id' => $request->accountID, 'code' => $this->generateCode(), 'title' => 'template', 'description' => 'template', 'demo_url' => 'initial', "content" => $request->content]
            // );
            // return response()->json(['test'=>$req]);
            $query = Template::firstOrNew(['account_id' => $request->account_id]);
            $query->fill([
                'account_id' => $request->account_id,
                'code' => $this->generateCode(),
                'title' => 'template',
                'description' => 'template',
                'demo_url' => 'initial',
                'content' => json_encode($req)
            ])
            ->save();
            $res = 'successfully added!';
        }catch(\Exception $e){
            $res = $e;
        }
        $this->response['data'] = $res;
        return $this->response();
    }

    public function generateCode(){
        $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
        $codeExist = Template::where('code', '=', $code)->get();
        if(sizeof($codeExist) > 0){
          $this->generateCode();
        }else{
          return $code;
        }
    }

    public function saveSettings(Request $request){
        $data = Template::firstOrNew(['account_id' => $request->account_id]);
        $data->fill([
            'account_id' => $request->account_id,
            'code' => $data['code'],
            'title' => $data['title'],
            'description' => $data['description'],
            'demo_url' => $data['demo_url'],
            'content' => $data['content'],
            'settings' => $request->setting
        ])
        ->save();
        return $this->response();
    }
}
