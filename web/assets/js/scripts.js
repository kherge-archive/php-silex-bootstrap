$(function () {
    "use strict";

    $('.input-add button').each(
        function () {
            $(this).click(
                function () {
                    var list = $(this).parents("ul");
                    var counter = list.data("counter");
                    var template = list.data("prototype");
                    var added = $("<li></li>");

                    added.html(template.replace(/__name__/g, counter++));
                    added.find("button").click(
                        function () {
                            $(this).parents("li").remove();
                        }
                    );

                    $(this).parent("li").before(added);

                    list.data("counter", counter);
                }
            );
        }
    );
});
