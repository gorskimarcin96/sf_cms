$(document).ready(function () {
    const checkedClasses = 'bg-primary text-light';

    $("input.todo-task[type=checkbox]").click(function () {
        const checkbox = $(this);
        const checked = checkbox.prop('checked');
        const card = checkbox.closest('.card');

        card.find('input:checkbox:not(":checked")').length === 0
            ? card.find('.todo-list-done').removeClass('disabled')
            : card.find('.todo-list-done').addClass('disabled');

        $.get({
            url: checked ? checkbox.data('urlIsDone') : checkbox.data('urlIsNotDone'),
            success: function () {
                checked
                    ? checkbox.closest('li').addClass(checkedClasses)
                    : checkbox.closest('li').removeClass(checkedClasses);
            }
        });
    });

    $("button.todo-list-done[type=button]").click(function () {
        const button = $(this);

        if(!confirm("Are you sure?")) {
            return;
        }

        $.get({
            url: button.data('url'),
            success: function () {
                button.closest('.card').parent().remove();
            }
        });
    });
})