require('./bootstrap');

require('alpinejs');
window.Echo.private('App.Model.User.' + UserId )
.notification((notification)=>
{alert(notification.body)
});