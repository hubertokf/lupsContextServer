require.config({
    baseUrl: "../../js/node_modules/",
    paths: {
        context : "../../js/lib/contextRules",
        root: "../../js/",
        jquery: "../../js/node_modules/jquery/dist/jquery.min",
        bootbox: "../../js/node_modules/bootbox/bootbox.min"
    }
});

require(["root/index_context"]);
