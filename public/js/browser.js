$(document).ready(function ()
{
    browse();
    function browse(dir, walk)
    {
        $.getJSON("browser.php", {
            dir: dir,
            tagmode: "any",
            format: "json"
        }).done(function (data)
        {
            var items = [];
            $.each(data.items, function (key, val)
            {
                var style = 'class = "file" ';
                var span_class = 'file';
                if (val.type === 'folder')
                {
                    var style = 'class="directory collapsed"';
                    var span_class = 'folder';
                }
                var id = val.path.replace(/\//g, "_").replace(/ /g, "_");
                var tmp_item = "" +
                    "<li " + style + " id='" + id +"' >" +
                        "<div class='row'>" +
                            "<div class='col-md-3'>" +
                                "<a href='#' data-path='" + val.path + "' data-type='" + val.type + "' data-path='" + val.path + "'>" +
                                    "<div class='" + span_class + "'>" +
                                        "<span>" + val.name + "</span>" +
                                    "</div>" +
                                "</a>" +
                            "</div>" +
                            "<div class='col-md-3 col-md-offset-1' >" + val.modified + "</div>" +
                            "<div class='col-md-3 col-md-offset-2'>" + val.size + "</div>" +
                        "</div>" +
                        "<div style='clear:both'></div>" +
                    "</li>" +
                    "<div style='clear:both'></div>";
                items.push(tmp_item);
                if (dir)
                {
                    var dir_id = dir.replace(/\//g, "_").replace(/ /g, "_");
                    $("<ul />", {
                        "class": "filetree",
                        html: tmp_item
                    }).appendTo('#' + dir_id);
                }
            });
            if (!dir)
            {
                $("<ul />", {
                    "class": "filetree",
                    html: items.join("")
                }).appendTo('#grid');
            }
        });
    }
    $(document).on('click', 'a', function (e)
    {
        e.preventDefault();
        var link = $(this);

        link.parent().addClass('loading');

        if( link.parent().parent().parent().hasClass('collapsed') )
        {
            link.parent().parent().parent().removeClass('collapsed').addClass('expanded');
            browse(link.data('path'), false);
            console.log(link.parent().parent().parent().find('UL').addClass('klasa'));
            link.parent().parent().parent().find('UL').addClass('klasa')
            link.parent().parent().parent().find('UL li div').find('col-md-offset-1').addClass('col-md-offset-fix')
        }
        else
        {
            link.parent().parent().parent().removeClass('expanded').addClass('collapsed');
            link.parent().parent().parent().find('UL').remove();// remove it from browser
        }
        link.parent().removeClass('loading');
        if(link.data('type') == 'file')
        {
            var file = link.data('path');
            $.ajax({
                type: 'POST',
                url: 'download.php',
                data: { file_path: file},
                success: function (data) {
                    window.location = 'download.php?file_path=' + file;
                }

            });
        }
        link.parent().removeClass('loading');

        //
    })
    });