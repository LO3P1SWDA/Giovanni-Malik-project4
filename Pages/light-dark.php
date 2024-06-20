<?php include "../headerNfooter/header.php";?>
<div class="background"></div>
<input type="checkbox" id="dark-mode">
  <label class="labelswitch" for="dark-mode"></label>
  <script>const darkModeCheckbox = document.getElementById('dark-mode');
const backgroundDiv = document.querySelector('.background');

darkModeCheckbox.addEventListener('change', function() {
  if (this.checked) {
    backgroundDiv.style.background = '#242424';
  } else {
    backgroundDiv.style.background = '#fff';
  }
});
</script>
<?php include "../headerNfooter/footer.php";?>