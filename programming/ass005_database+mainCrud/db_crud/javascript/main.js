// document.getElementById('myForm').addEventListener("submit", SubmitFunction);

function SubmitCallback(result) {
    document.getElementById('myTable').innerHTML = result;
}

function SubmitFunction(crudFunc, id, naam, leeftijd) {
    let payload = {dbcrud: crudFunc,
        // id: document.getElementById('id').value,
        // naam: document.getElementById('naam').value,
        // leeftijd: document.getElementById('leeftijd').value
    }
    console.log(payload);
    ajax_module.post('php_includes/main.php', {}, SubmitCallback, payload, 0);
}

const Onload = (function() {
    payload = { dbcrud: read}
    ajax_module.post('php_includes/main.php', {}, SubmitCallback, payload, 0);
})();




//addEventListener
// document.getElementById('create').addEventListener("click", function() {
//     SubmitFunction('create')
// });

document.getElementById('read').addEventListener("click", function() {
    SubmitFunction('read')
});

let updateBtns = document.querySelectorAll(".upd-button");
for (var i = 0; i < updateBtns.length; i++) {
    updateBtns[i].addEventListener("click", function(e) {
        // console.log(e.target.value)
        // id= querySelector('')
        SubmitFunction('update')
    }, 1);
}

let deleteBtns = document.querySelectorAll(".del-button");
for (var i = 0; i < deleteBtns.length; i++) {;
    deleteBtns[i].addEventListener("click", function() {
        SubmitFunction('delete')
    });
}
