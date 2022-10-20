function active_entrega() {
  var expReg = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
  var file_btn = document.querySelector("#default-btn");
  var text_file = document.querySelector(".file-name");
  var img = document.querySelector("#img-file-foto");
  $("#chose-file").on("click", (e) => {
    console.log("click dang drop");
    file_btn.click();
  });
  $("#btn-cancel-file").on("click", (e) => {
    img.src = "";
    $("#dang_drop .image").removeClass("view-change");
    $("#dang_drop .cancel-btn").removeClass("view-change");
    file_btn.value = "";
  });
  file_btn.addEventListener("change", function () {
    const file = this.files[0];
    var ext = file.name.split(".").pop();
    if (file) {
      switch (ext) {
        case "pdf":
          img.src = "../img/vector-pdf.png";
          break;
        case "xlsx":
          img.src = "../img/vector-excel.png";
          break;
        case "docx":
          img.src = "../img/vector-word.png";
          break;
      }
      $("#dang_drop .image").addClass("view-change");
      $("#dang_drop .cancel-btn").addClass("view-change");
    }
    if (this.value) {
      let valueStore = this.value.match(expReg);
      text_file.textContent = valueStore;
    }
  });
}
