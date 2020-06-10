const resetTabs = function (container) {
    const activeLink = getActiveTabLink(container);
    const activePanel = $(activeLink.attr('href'));
    
    activeLink.removeClass('active');

    // Fire utility event indicating that we are going
    // to hide the tab panel
    activePanel.trigger('curate.tabs.hide');
    activePanel.hide(function () {
        $(this).removeClass('show');

        // Trigger event to indicate that the
        // tab panel is hidden
        $(this).trigger('curate.tabs.hidden');
    });
};

const showTab = function (link) {
    const panel = $(link.attr('href'));

    link.addClass('active');
    
    // Fire utility event indicating that we are going
    // to show the tab panel
    panel.trigger('curate.tabs.show');
    panel.show(function () {
        $(this).addClass('show');
        // Trigger event to indicate that the
        // tab panel is shown
        $(this).trigger('curate.tabs.shown');
    });
};

const getActiveTabLink = function (container) {
    return container.find('.tab-link.active').first();
};

$(function () {
    $('a[aria-controls="tab"].tab-link').on('click', function (e) {
        e.preventDefault();

        const button = $(this);
        const link = button.closest('.tabs.tabs-nav');

        window.location.hash = '';
        resetTabs(link);
        showTab(button);
    });

    // Listen to all tabs "show" events on tab panels
    $('.tab-panel').on('curate.tabs.show', function () {
        const id = $(this).attr('id');
        const panel = $('#' + id);

        // Make an AJAX request to get randomly generated text
        $.ajax({
            url: '/admins/text/random',
            data: {
                id: id,
            },
            beforeSend: () => {
                // Display the loading spinner
                panel.html('<div class="width-100% text-center icon-container">'
                    + '<i class="fa fa-circle-notch spin color-primary"></i>'
                    + '</div>');
            },
        }).done(response => {
            // Fill the tab panel with the text from the response
            panel.html(response.text);
        }).always(() => {
            panel.find('div.icon-container').remove();
        });
    });

    // On page load, we want to show all of the "active" tab panels
    // Active panels can be determined by adding the "active" class
    // to the .tab-link
    $('a[aria-controls="tab"].tab-link.active').each(function () {
        $(this).trigger('click');
    });
});