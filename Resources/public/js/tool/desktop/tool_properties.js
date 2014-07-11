/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

(function () {
    'use strict';

    var stackedRequests = 0;

    $.ajaxSetup({
        beforeSend: function () {
            stackedRequests++;
            $('.please-wait').show();
        },
        complete: function () {
            stackedRequests--;
            if (stackedRequests === 0) {
                $('.please-wait').hide();
            }
        }
    });

    $('.chk-tool-visible').on('change', function (e) {
        var toolId = $(e.target.parentElement.parentElement).attr('data-tool-id'),
            rowIndex = e.target.parentElement.parentElement.rowIndex,
            rows = $('#tool-table tr'),
            isCurrentRowChecked = rows.eq(rowIndex)[0].children[1].children[0].checked,
            route = '';

        if (isCurrentRowChecked) {
            route = Routing.generate(
                'claro_tool_desktop_add',
                { 'tool': toolId, 'position': rowIndex }
            );
        } else {
            route = Routing.generate(
                'claro_tool_desktop_remove',
                { 'tool': toolId }
            );
        }

        $.ajax({url: route, type: 'POST'});
    });

    $('.fa-arrow-circle-up').on('click', function (e) {
        var rowIndex = e.target.parentElement.parentElement.rowIndex;
        moveRowUp(rowIndex);
    });

    $('.fa-arrow-circle-down').on('click', function (e) {
        var rowIndex = e.target.parentElement.parentElement.rowIndex;
        moveRowDown(rowIndex);
    });

	function moveRowUp(index) {
        var rows = $('#tool-table tr'),
            toolId;

        if (index !== 1) {
            rows.eq(index).insertBefore(rows.eq(index - 1));
            var isCurrentRowChecked = rows.eq(index)[0].children[1].children[0].checked;
            if (isCurrentRowChecked) {
                toolId = $(rows.eq(index)[0]).attr('data-tool-id');
                index = index - 1;
            } else {
                toolId = $(rows.eq(index - 1)[0]).attr('data-tool-id');
            }
            var route = Routing.generate(
                'claro_tool_desktop_move',
                { 'tool': toolId, 'position': index }
            );
            $.ajax({url: route, type: 'POST'});
            setOrderingIconsState();
        }
	}

    function moveRowDown(index) {
        var rows = $('#tool-table tr'),
            size = rows.length,
            toolId;
        rows.eq(index).insertAfter(rows.eq(index + 1));


        if (index !== size) {
            var isCurrentRowChecked = rows.eq(index)[0].children[1].children[0].checked;
            if (isCurrentRowChecked) {
                toolId = $(rows.eq(index)[0]).attr('data-tool-id');
                index = index + 1;
            } else {
                toolId = $(rows.eq(index + 1)[0]).attr('data-tool-id');
            }
        }
        var route = Routing.generate(
            'claro_tool_desktop_move',
            { 'tool': toolId, 'position': index }
        );
        $.ajax({url: route, type: 'POST'});
        setOrderingIconsState();
    }

    function setOrderingIconsState() {
        var upIcons = $('#tool-table span.ordering-icon.up');
        var downIcons = $('#tool-table span.ordering-icon.down');
        var downLength = downIcons.length;

        upIcons.each(function (index, icon) {
            $(icon)[(index === 0 ? 'addClass' : 'removeClass')]('disabled');
        });
        downIcons.each(function (index, icon) {
            $(icon)[index === downLength - 1 ? 'addClass' : 'removeClass']('disabled');
        });
    }
})();

