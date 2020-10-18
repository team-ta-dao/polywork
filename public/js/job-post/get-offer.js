var listOffer = [];

function test(obj) {
  if (obj.checked) {
    // console.log(obj.textContent);
    // console.log(obj.value);
    listOffer.push(obj.value);
  } else {
    for (let index = 0; index < listOffer.length; index++) {
        const element = listOffer[index];
        if (obj.value == element) {
            listOffer.splice(index, 1);
        }
    }
  }

  console.log(listOffer);
}
