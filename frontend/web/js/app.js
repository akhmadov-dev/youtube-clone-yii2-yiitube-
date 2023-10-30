$(function () {
    const $leaveComment = $('#leave-comment');
    const $cancelComment = $('#cancel-comment');
    const $createCommentForm = $('#create-comment-form');
    const $commentsWrapper = $('#comments-wrapper');
    const $commentCount = $('#comment-count');
    const $deleteComment = $('.comment-actions .item-delete-comment');

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
                $deleteComment
                    .off('click')
                    .on('click', onDeleteClick);
            }
        })
            .done(function () {
                console.log(arguments);
            });
    });

    $deleteComment.on('click', onDeleteClick);


    function resetForm() {
        $leaveComment
            .val('')
            .attr('rows', 1);
        $cancelComment
            .closest('.create-comment')
            .removeClass('focused');
    }

    function onDeleteClick(ev) {
        ev.preventDefault();
        const $delete = $(ev.target);

        if (confirm('Are you sure you want to delete that comment?')) {
            $.ajax({
                method: 'post',
                url: $delete.attr('href'),
                success: function () {
                    $delete.closest('.comment-item').remove();
                    $commentCount.text(parseInt($commentCount.text()) - 1);
                }
            });
        }
    }
});