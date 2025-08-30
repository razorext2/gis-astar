self.addEventListener("push", function (event) {
  const swVersion = '1.0.9';

  let data = event.data.json();

  const title = data.title;
  const options = {
    body: data.body,
    icon: data.icon,
    badge: data.badge,
    data: { url: data.data.url },
    actions: data.actions,
    tag: data.tag
  };

  event.waitUntil(
    self.registration.showNotification(title, options)
  );
});

self.addEventListener("notificationclick", function (event) {
  event.notification.close();

  let url = event.notification.data.url;

  // buka tab baru atau fokuskan tab yang sudah ada
  event.waitUntil(
    clients.matchAll({ type: "window", includeUncontrolled: true }).then(function (clientList) {
      for (let i = 0; i < clientList.length; i++) {
        let client = clientList[i];
        if (client.url === url && "focus" in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(url);
      }
    })
  );
});
