require.config({
    baseUrl: "./node_modules",
    paths: {
        aquisitionsRules : "../../js/lib/aquisitionsRules",
        root: "../../js",
        jquery: "../../js/node_modules/jquery/dist/jquery.min",
        bootbox: "../../js/node_modules/bootbox/bootbox.min"
    }
});

require(["root/index_aquisition"]);
