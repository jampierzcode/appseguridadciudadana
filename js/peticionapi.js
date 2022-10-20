document.addEventListener("DOMContentLoaded", () => {
  llamarapi();
});
async function llamarapi() {
  const res = await fetch("../js/api.json");
  var data = await res.json();
  console.log(data);
  let template = "";
  data.forEach((productos) => {
    template += `
    <div class="productos-list" key="${productos.id}">
        <img src="${productos.thumbnailUrl}">
      <p>Nombre: ${productos.title}</p>
      <p>Precio: S/${productos.precio}.00</p>
    </div>
      `;
  });
  $("#productsdata").html(template);
}
// 
