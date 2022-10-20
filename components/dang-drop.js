$(document).ready(function () {
  var expReg = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
  var file_btn = document.querySelector("#default-btn");
  var text_file = document.querySelector(".file-name");
  var img = document.querySelector("#img-file-foto");
  $("#chose-file").on("click", (e) => {
    file_btn.click();
  });
  $("#btn-cancel-file").on("click", (e) => {
    img.src = "";
    $("#dang_drop .image").removeClass("view-change");
    $("#dang_drop .cancel-btn").removeClass("view-change");
    file_btn.value = "";
    console.log(file_btn.value);
  });
  file_btn.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        const result = reader.result;
        img.src = result;
        $("#dang_drop .image").addClass("view-change");
        $("#dang_drop .cancel-btn").addClass("view-change");
      };

      reader.readAsDataURL(file);
    }
    if (this.value) {
      let valueStore = this.value.match(expReg);
      text_file.textContent = valueStore;
    }
  });
});
