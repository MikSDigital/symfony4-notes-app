
$(document).ready(function () {

    let timer;

    $(".note-content").keyup(function () {
        const $this = $(this);
        clearTimeout(timer);

        timer = setTimeout(function () {

            let content = $this.val();
            let id = $this.next().val();
            $.ajax({
            type: "POST",
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            url: "/save",
            data: {content: content, id : id},
            success: function (data) {
                console.log(data);
            },
        });

        }, 2000);
    });

    //on keydown, clear the countdown
$(".note-content").on("keydown", function () {
    clearTimeout(timer);
});

function displaySpinner() {
    $('.note-content').before('<i class="fa fa-spinner fa-spin"></i>');
}
displaySpinner();
});



// var typingTimer;
// var doneTypingInterval = 2000;
//
// //on keyup, start the countdown
// $('.note-content').on("keyup", function () {
//     if (typingTimer) clearTimeout(typingTimer);
//     let content = $(this).val();
//     let id = $(this).next().val();
//     typingTimer = setTimeout(doneTyping(content, id), doneTypingInterval);
// });
//
// //on keydown, clear the countdown
// $('.note-content').on("keydown", function () {
//     clearTimeout(typingTimer);
// });
//
// //user is "finished typing
// function doneTyping(content, id) {
//     id = id;
//
//     // id = $("#note-content").next().val();
//      content = content;
//
//     $.ajax({
//         type: "POST",
//         contentType: 'application/x-www-form-urlencoded',
//         dataType: 'json',
//         url: "/save",
//         data: {content: content, id : id},
//         success: function (data) {
//             console.log(data);
//         },
//     });
//
// }

