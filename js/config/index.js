require.config({
    baseUrl: "../../js/node_modules/",
    paths: {
        lib: "../../js/lib",
        aaquisitionsRules : "../../js/lib/aquisitionsRules",
        root: "../../js/",
        jquery: "../../js/node_modules/jquery/dist/jquery.min",
        bootbox: "../../js/node_modules/bootbox/bootbox.min"
    }
});

require(["root/index"]);
