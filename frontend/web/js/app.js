$(function () {
    const $leaveComment = $('#leave-comment');
    const $cancelComment = $('#cancel-comment');
    const $submitComment = $('#submit-comment');
    const $createCommentForm = $('#create-comment-form');
    const $commentsWrapper = $('#comments-wrapper');
    const $commentCount = $('#comment-count');

    $leaveComment.click(function () {
        $leaveComment
            .attr('rows', '2')
            .closest('.create-comment')
            .addClass('focused');
    });

    $cancelComment.click(resetForm);

    $createCommentForm.submit(ev => {
        ev.preventDefault();

        $.ajax({
            method: $createCommentForm.attr('method'),
            url: $createCommentForm.attr('action'),
            data: $createCommentForm.serializeArray(),
            success: function (res) {
                $commentsWrapper.prepend(res.comment);
                resetForm();
                $commentCount.text(parseInt($commentCount.text()) + 1);
            }
        })
            .done(function () {
                console.log(arguments);
            });
    });

    function resetForm() {
        $leaveComment
            .val('')
            .attr('rows', 1);
        $cancelComment
            .closest('.create-comment')
            .removeClass('focused');
    }
});