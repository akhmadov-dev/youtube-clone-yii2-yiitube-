$(function () {
    const $leaveComment = $('#leave-comment');
    const $cancelComment = $('#cancel-comment');
    const $submitComment = $('#submit-comment');
    const $createCommentForm = $('#create-comment-form');

    $leaveComment.click(function () {
        $leaveComment
            .attr('rows', '2')
            .closest('.create-comment')
            .addClass('focused');
    });

    $cancelComment.click(() => {
        $leaveComment.attr('rows', 1);
        $cancelComment
            .closest('.create-comment')
            .removeClass('focused');
    });

    $createCommentForm.submit(ev => {
        ev.preventDefault();

        $.ajax({
            method: $createCommentForm.attr('method'),
            url: $createCommentForm.attr('action'),
            data: $createCommentForm.serializeArray(),
            success: function () {
                console.log(arguments)
            }
        })
            .done(function () {
                console.log(arguments);
            });
    });
});