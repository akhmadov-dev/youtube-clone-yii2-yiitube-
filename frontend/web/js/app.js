$(function () {
    const $leaveComment = $('#leave-comment');
    const $cancelComment = $('#cancel-comment');
    const $submitComment = $('#submit-comment');

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
});