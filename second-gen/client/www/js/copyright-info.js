/*

для удобства http://www.utilities-online.info/urlencode/
https://html-plus.in.ua/sozdanie-html-yelementov-v-javascript/
https://stackoverflow.com/questions/6432984/how-to-add-a-script-element-to-the-dom-and-execute-its-code

*/

function addCopyright() {

    let div = document.createElement("div");
    div.className = "copy";
    div.innerHTML = unescape('%3Cdiv%20class%3D%22year%22%3E%A9%202001-2020%20SMIRART%3C/div%3E%0A%3Cdiv%20class%3D%22author%22%3EOpenSource%20on%20%3Ca%20href%3D%22https%3A//github.com/urpylka/swe%22%20target%3D%22_blank%22%3Egithub%3C/a%3E%3C/div%3E%0A');

    document.querySelector('footer').appendChild(div);
}
