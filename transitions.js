document.addEventListener('DOMContentLoaded', () => {
  document.body.style.transition = 'opacity 0.15s ease';
  document.body.style.opacity = '1';
});

document.addEventListener('click', (e) => {
  const link = e.target.closest('a[href]');
  if (!link) return;
  try {
    const url = new URL(link.href, location.href);
    if (url.hostname !== location.hostname) return;
    if (link.target === '_blank') return;
    if (url.pathname.endsWith('.pdf')) return;
    e.preventDefault();
    document.body.style.transition = 'opacity 0.15s ease';
    document.body.style.opacity = '0';
    setTimeout(() => { location.href = link.href; }, 150);
  } catch(err) {}
});
