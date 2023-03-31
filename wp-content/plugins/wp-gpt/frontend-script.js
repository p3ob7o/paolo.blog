document.addEventListener('DOMContentLoaded', () => {
  const tweetButtons = document.querySelectorAll('.wp-gpt-social-quote button');

  tweetButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const quote = button.previousSibling.innerText;
      const tweetContent = `${quote}`;
      const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetContent)}`;
      window.open(tweetUrl, '_blank');
    });
  });
});
