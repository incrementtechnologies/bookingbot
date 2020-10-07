<?php

namespace App\Http\Controllers;

use App\BotTemplate as Template;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BotTemplateController extends APIController
{
    function __construct(){
        $this->model = new Template();
    }

    public function retrieve_content(Request $request){
        $req = json_decode($request->getContent());
        $res = Template::select('content')
        ->where('account_id', $req->account_id)
        ->get();
        $res = json_decode($res);
        return response()->json($res);
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
                        $fileUrl = str_replace(' ', '_', $file->getClientOriginalName());
                        $fileUrl = str_replace('%20', '_', $fileUrl);
                        $filename = $request->account_id.'_'.$date.'_'.$time.'_'.$fileUrl;
                        $file->storeAs('images', $filename);
                        $url = '/storage/image/'.$filename;
                        $image = $url;
                    }
                    $req->data[$i]->data->reply[$x]->image = $image;
                }
            }
        }
        try{
            // \DB::table('bot_templates')->insert(
            //     ['account_id' => $request->accountID, 'code' => $this->generateCode(), 'title' => 'template', 'description' => 'template', 'demo_url' => 'initial', "content" => $request->content]
            // );
            // return response()->json(['test'=>$req]);
            $test = Template::firstOrNew(['account_id' => $request->account_id]);
            $test->fill([
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
}
