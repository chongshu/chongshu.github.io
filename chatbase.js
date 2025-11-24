(function() {
  if (!window.chatbase || window.chatbase("getState") !== "initialized") {
    window.chatbase = (...arguments) => {
      if (!window.chatbase.q) { window.chatbase.q = []; }
      window.chatbase.q.push(arguments);
    };
    window.chatbase = new Proxy(window.chatbase, {
      get(target, prop) {
        if (prop === "q") { return target.q; }
        return (...args) => target(prop, ...args);
      }
    });
  }

  const onLoad = function() {
    const script = document.createElement("script");
    script.src = "https://www.chatbase.co/embed.min.js";
    script.id = "qkjodeN7nOtsuxAHG0VK7";
    script.domain = "www.chatbase.co";
    document.body.appendChild(script);

    // --------- FRONT-PAGE CHECK ----------
    const isFrontPage = (() => {
      // Hosted site: accept chong-shu.com and subdomains (www, etc.)
      const hostOk = window.location.hostname &&
                     (window.location.hostname === "chong-shu.com" ||
                      window.location.hostname.endsWith(".chong-shu.com"));

      // Path check: root (/) or explicit index.html
      const pathOk = window.location.pathname === "/" ||
                     window.location.pathname.endsWith("/index.html") ||
                     window.location.href.indexOf("index.html") !== -1;

      // Local file testing (file://) — allow when the file path contains index.html
      const localOk = window.location.protocol === "file:" &&
                      (window.location.href.indexOf("index.html") !== -1 ||
                       /[\/\\]index\.html$/i.test(window.location.pathname));

      return (hostOk && pathOk) || localOk;
    })();
    // ------------------------------------

    if (!isFrontPage) return; // stop here on non-front pages

    // Try clicking the chat button automatically after 1 second (your working selector)
    setTimeout(() => {
      const button = document.querySelector('button, .chatbase-button, .cb-launch, [data-chatbase-toggle]');
      if (button) {
        button.click();
        console.log("Chatbase button clicked automatically (front page).");
      } else {
        console.log("Chatbase button not found (front page).");
      }
    }, 1000);
  };

  if (document.readyState === "complete") {
    onLoad();
  } else {
    window.addEventListener("load", onLoad);
  }
})();
