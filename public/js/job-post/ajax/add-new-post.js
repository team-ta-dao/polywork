$(document).ready(function () {
  var publish = $("#publish");

  publish.on("click", function () {
    // single data
    const companyID = $("#slt-company").find(":selected").val();
    const title = $("#job-title").val();
    const location = $("#job-location").val();
    const jobContentData = jobContent.getData();
    const jobRequireDara = jobRequire.getData();
    const employerNeed = $("#employer-need").val();
    const salary = $("#job-salary").val();

    var isShowSalary = 1;
    if (!document.querySelector('input[name="is-show-salary"]').checked) {
      isShowSalary = 0;
    }

    // multiple data
    let offers = listOffer;
    let category = $('#job-level input[name="job-level"]:checked').val();
    let level = $('#post-category input[name="category"]:checked').val();

    // expire day
    let expireDay = $("#to-day").val();

    $.ajax({
      url: "/post/add-new-post",
      type: "POST",
      dataType: "json",
      data: {
        // csrf token to check data from app
        _token: $('meta[name="csrf-token"]').attr("content"),
        company_id: companyID,
        jp_title: title,
        jp_location: location,
        jp_desc: jobContentData,
        jp_require: jobRequireDara,
        jp_employee_needed: employerNeed,
        jp_salary: salary,
        jp_show_salary: isShowSalary,
        offers: offers,
        jp_level: level,
        jc_id: category,
        jp_expired_date: expireDay
      },
      success: function (res) {},
    });
  });
});
