function updateCard(obj) {
  var companyId = obj.value;
  var token = $('meta[name="csrf-token"]').attr("content");

  //get comapny cart item
  var cover = document.querySelector("#company #cover-img");
  var avatar = document.querySelector("#company #avatar");
  var desc = document.querySelector("#company #desc");
  var template = `<div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-orange-600 border-orange-500 hover:bg-orange-500 hover:text-orange-100 cursor-default"></div>`;
  var category = document.querySelector("#company #job-cat");

  // Run ajax to get full infomation of company
  $.ajax({
    url: "/post/get-company-info",
    type: "POST",
    dataType: "json",
    data: {
      _token: token,
      companyId: companyId,
    },
    success: function (response) {
      var result = response.shift();
      // console.log(result);
      cover.setAttribute("src", result.cover_img);
      avatar.setAttribute("src", result.avatar);
      category.innerText = result.name;
    },
  });
}

function test(obj) {
  console.log(obj.value);
}
