$(document).ready(function () {

    $(".note-snippet").click(function () {
        let id = $(this).attr('class').match(/\d+/);
        let selectedNote = $('.notes').children().eq(id);
        $('.note').hide();
        selectedNote.show();
        console.log(selectedNote);
    });


    let timer;
    $(".note-content").keyup(function () {
        $saveInfo = $('.saving-note p');
        if (!$saveInfo.text().length) {
            $saveInfo.append('<i class="fa fa-spinner fa-spin"></i> <span class="saving"> Saving...</span>');
        }

        const $this = $(this);
        clearTimeout(timer);

        timer = setTimeout(function () {

            let content = $this.val();
            content = content.trim();
            let id = $this.next().val();
            $saveInfo.empty();
            $saveInfo.append('<span class="saved">Saved!</span>');

            $.ajax({
                type: "POST",
                contentType: 'application/x-www-form-urlencoded',
                dataType: 'json',
                url: "/save",
                data: {content: content, id: id}
            });

        }, 2000);
    });

    //on keydown, clear the countdown
    $(".note-content").on("keydown", function () {
        clearTimeout(timer);
    });


});
