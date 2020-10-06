export default {
  sidebarMenu: [
    {accountType: 'ALL', accountStatus: 'ALL', showOnAdmin: false, description: 'Dashboard', icon: 'fa fa-tachometer-alt', path: 'dashboard', flag: false, subMenu: null},
    {accountType: 'ADMIN', accountStatus: 'ALL', showOnAdmin: true, description: 'Account', icon: 'fa fa-tachometer-alt', path: 'accounts', flag: false, subMenu: null}
  ],
  profileMenu: [{
    title: 'My Profile',
    icon: 'fa fa-cog',
    route: '/profile'
  }, {
    title: 'Invite Friends',
    icon: 'fa fa-users',
    route: '/referrals'
  }],
  APP_NAME: 'BookingBot',
  APP_NAME_HTML: 'BookingBot',
  APP_EMAIL: 'support@runwayexpress.com',
  COMPANY: 'Increment Technologies Inc.',
  COMPANY_URL: 'http://increment.ltd',
  APP_URL: 'https://runwayexpress.com',
  COPYRIGHT: 'BookingBot ' + new Date().getFullYear(),
  USER_TYPE: [{
    title: 'USER'
  }, {
    title: 'MERCHANT'
  }, {
    title: 'RIDER'
  }, {
    title: 'ADMIN'
  }],
  plan: false,
  header: ['status', 'notification'], // 'messenger', '',
  settingsMenu: [
    {title: 'Profile', hideFrom: ['MERCHANT'], type: 'profile', allowed: ['cellular_number', 'address', 'sex', 'birth_date']},
    {title: 'Notifications', hideFrom: [], type: 'notification', allowed: []},
    {title: 'Account', hideFrom: [], type: 'account', allowed: []}
  ],
  notificationSeting: [{
    title: 'OTP',
    flag: true
  }, {
    title: 'SMS',
    flag: true
  }, {
    title: 'EMAIL',
    flag: true
  }],
  referral: {
    message: 'to get deals on selected items!',
    emailMessage: ', a brand new food delivery app. Check out their awesome deals!',
    promotion: ''
  },
  socialMedia: {
    facebook: 'runwayexpress'
  },
  pusher: {
    channel: 'bookingbot',
    private: 'runway_broadcast',
    notifications: 'Notifications',
    messages: 'Message',
    validation: 'Validation'
  },
  broadcastingFlag: true,
  passwordLimit: 8,
  alertFlag: false
}
