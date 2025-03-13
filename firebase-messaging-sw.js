importScripts('https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js');


      const firebaseConfig = {

 apiKey: "AIzaSyB13UyX3p2HVCjY_st8uoRKPmaruUJBDGI",

  authDomain: "tibloo.firebaseapp.com",

  projectId: "tibloo",

  storageBucket: "tibloo.appspot.com",

  messagingSenderId: "205732121364",

  appId: "1:205732121364:web:30976778f88680207b9001",

  measurementId: "G-SJ4C5END3X"



};

firebase.initializeApp(firebaseConfig);
const messaging=firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(payload);
    const notification=JSON.parse(payload);
    const notificationOption={
        body:notification.body,
        icon:notification.icon
    };
    return self.registration.showNotification(payload.notification.title,notificationOption);
});