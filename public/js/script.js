// Hide & unhide password
let visible = document.querySelectorAll(".visible");
console.log(visible);
visible.forEach((e) => {
  e.addEventListener("click", () => {
    e.classList.toggle("fa-eye");
    e.classList.toggle("fa-eye-slash");
    let password = e.nextElementSibling;
    if (password.getAttribute("type") == "password") {
      password.setAttribute("type", "text");
    } else {
      password.setAttribute("type", "password");
    }
  });
});


// SweetAlert2
// >>>>AlertSuccess
const flashData = $(".flash-data").data("flashdata");
if (flashData) {
  Swal.fire({
    icon: "success",
    title: "Onesport",
    text: flashData,
    showConfirmButton: false,
    timer: 1500,
  });
}

// cancel transaction
// >>>>AlertDanger
$(".btn-cancel").on("click", function (e) {
  e.preventDefault();
  Swal.fire({
    title: "Batalkan Transaksi?",
    text: "Dengan mengklik tombol setuju transaksi anda akan dibatalkan secara otomatis. Untuk pengembalian dana Admin Onesport akan menghubungi anda via email max 1x24Jam!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Setuju",
  }).then((result) => {
    if (result.isConfirmed) {
      $(this).unbind("click").click();
    }
  });
});




// >>>>AlertDanger
$(".btn-delete").on("click", function (e) {
  e.preventDefault();
  Swal.fire({
    title: "Are you sure?",
    text: "You will delete this data",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $(this).unbind("click").click();
    }
  });
});

//preview image input

// preview img
function previewImg(input, preview) {
  const upload = document.querySelector(`#${input}`);
  const imgPreview = document.querySelector(`.${preview}`);
  const content = new FileReader();
  console.log(imgPreview);
  content.readAsDataURL(upload.files[0]);
  content.onload = function (e) {
    imgPreview.src = e.target.result;
    imgPreview.classList.add("object-fit");
    imgPreview.classList.remove("icon-plus");
  };
}



// event ketika keyword di tulis
$("#keyword").on("keyup keydown", function () {
  var keyword = $(this).val();
  console.log(keyword);
  const suggWrapper = document.querySelector(".search-suggestion");
  if (keyword) {
    suggWrapper.classList.remove("d-none");
    cari(keyword);
    $("body").on("click", () => {
      suggWrapper.classList.add("d-none");
    });
  } else {
    suggWrapper.classList.add("d-none");
  }
});

function cari(keyword) {

  const suggVenue = document.querySelector(".suggestVenue");
  const suggField = document.querySelector(".suggestField");
  const elNoData = $(".js-no-data")[0];

  $.ajax({
    type: "post",
    data: keyword,
    url: "/search?keyword=" + keyword,
    success: function (res) {
      let result = JSON.parse(res);
      let venues, fields = Array();
      venues = result['venues']
      fields = result['fields']
      let listVenue = "";
      let listField = "";
      let noData = "";

      if(venues.length > 0){
        suggVenue.classList.remove("d-none");
        listVenue +=`<h6 class="font-weight-bold">Venue</h6>`
        venues.forEach((venue)=>{
          listVenue +=`
          <a href="/main/venue/${venue["slug"]}" class="list-group-item list-group-item-action">
            <div class="row align-items-center">
                <div class="col-3">
                    <img class="rounded-circle img-responsive" width="100%" src="/img/venue/logos/${venue["logo"]}">
                </div>
                <div class="col-9">
                    <p class="small mb-0">${venue["venue_name"]}</p>
                </div>
            </div>
          </a>
          `;
        })
      }
      if(fields.length > 0){
        suggField.classList.remove("d-none");
        listField +=`<h6 class="font-weight-bold">Lapangan</h6>`
        fields.forEach((field)=>{
          listField +=`
          <a href="/main/field/${field["slug"]}" class="list-group-item list-group-item-action">
            <div class="row align-items-center">
                <div class="col-3">
                    <img class="img-responsive" width="100%" src="/img/venue/arena/fields/main-images/${field["field_image"]}">
                </div>
                <div class="col-9">
                    <p class="small mb-0">${field["field_name"]}</p>
                </div>
            </div>
          </a>
          `;
        })
      }
      
      // tambahkan hr
      listVenue += "<hr>";
      listField += "<hr>";

      if (venues.length == 0 && fields.length == 0) {
        suggVenue.classList.add("d-none");
        suggField.classList.add("d-none");
        noData += `
        <div class="col-12">
          <p class="small mb-0">Yah venue atau lapangan "${keyword}" yang kamu cari tidak ada <i class="fa-solid fa-face-sad-tear text-primary"></i>, Yuk move on cari yang lain!</p>
        </div>
        `;
      }

      suggVenue.innerHTML = listVenue
      suggField.innerHTML = listField;
      elNoData.innerHTML = noData;
    },
  });
}



// tiny Rich text editor
tinymce.init({
  selector: ".tiny-textarea",
  plugins: "advlist autolink lists link image charmap print preview hr anchor pagebreak",
  toolbar_mode: "floating",
});



$("#sidebarToggle").on("click", () => {
  $(".no-toggled").removeClass("toggled");
});

// btn reject order
let btnReject = document.querySelectorAll(".btn-reject");
btnReject.forEach((e) => {
  e.addEventListener("click", () => {
    let id = $(e).data("id");
    console.log(id);
    $("#detail-id").val(id);
  });
});
