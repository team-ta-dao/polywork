let jobContent;
let jobRequire;

// Job Content
ClassicEditor.create(document.querySelector("#job-content"))
  .then((newEditor) => {
    jobContent = newEditor;
  })
  .catch((error) => {
    console.error(error);
  });

// Job Require
ClassicEditor.create(document.querySelector("#job-require"))
  .then((newEditor) => {
    jobRequire = newEditor;
  })
  .catch((error) => {
    console.error(error);
  });