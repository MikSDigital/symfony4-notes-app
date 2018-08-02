$(document).ready(function () {

    $(".note-snippet").click(function () {
        let id = $(this).attr('class').match(/\d+/);
        let selectedNote = $('.notes').children().eq(id);
        let noteForm = $('.share-area').children().eq(id);
        $('.share-form').hide();
        $('.share-info').empty();
        $('.note').hide();
        noteForm.show();
        selectedNote.show();
        console.log(noteForm);
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


    $(".share-submit").click(function () {

        let patt = new RegExp('^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$');
        let title = $(this).parent().prev().find("input").val();
        let result = patt.test(title);
        let info = $('.share-info');
        title = title.trim();

        if (title.length > 30) {
            $('.share-message').remove();
            $(this).parent().append("<p class='share-message'>You can enter only 30 characters!</p>");
        }

        else if (result) {
            let id = $(this).parent().next().val();

            $.ajax({
                type: "POST",
                contentType: 'application/x-www-form-urlencoded',
                dataType: 'json',
                url: "/share",
                data: {title: title, id: id},
                success: function (data) {
                    $('.share-message').remove();
                    info.html('URL to the note:  <a href="' + data['url'] + '">' + data['url'] + '</a> '
                    + '<button type="button" class="copyToClipboard">Copy link</button>');
                },
            });
        } else {
            $('.share-message').remove();
            $(this).parent().append("<p class='share-message'>Your input is wrong! You can only enter letters and numbers!</p>");
        }

    });


    $(document).on('click', '.copyToClipboard',function () {
        $(this).attr('data-tooltip', 'Copied!');
        setTimeout(function () {
            $('.copyToClipboard').removeAttr('data-tooltip');
        }, 1300);

        let href = $(this).prev().attr('href');
        let $temp = document.createElement("textarea");
        $temp.value = href;
        document.body.appendChild($temp);
        $temp.select();
        document.execCommand('copy');
        $temp.remove();
        console.log(href);
    });



});
