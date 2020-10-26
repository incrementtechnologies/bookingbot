// let LIVE_BACKEND_URL = 'https://api.payhiram.increment.ltd/public/increment/v1'
let LIVE_BACKEND_URL = 'https://api.bookingbot.asia/server.php/increment/v1'
// let DEV_BACKEND_URL = 'http://localhost/bookingbot/public/increment/v1'
let DEV_BACKEND_URL = 'http://localhost:8000'
let isDev = true
let broadcastFlag = 'self' // self, pusher
let BACKEND_URL = isDev ? DEV_BACKEND_URL : LIVE_BACKEND_URL
let pusherKey = isDev ? 'ASDASDD' : 'ASDASDD'
let wsHost = isDev ? 'bookingbot.asia' : 'bookingbot.asia'
let wsPort = isDev ? 6001 : 6001
export default{
  IS_DEV: isDev,
  API_URL: BACKEND_URL + '/',
  API_URL_BROADCAST: BACKEND_URL + '/authenticate/broadcast_auth',
  IMAGE_URL: BACKEND_URL + '/image/',
  BACKEND_URL: BACKEND_URL,
  PUSHER: {
    flag: broadcastFlag,
    key: broadcastFlag === 'pusher' ? '92d03f6cdbc9b3e7467b' : pusherKey,
    wsHost: wsHost,
    wssPort: wsPort,
    wsPort: wsPort
  },
  APP_NAME: 'BookingBot',
  APP_NAME_VHTML: 'BookingBot',
  APP_EMAIL: 'support@bookingbot.asia',
  USER_TYPE: [{
    title: 'USER'
  }]
}
