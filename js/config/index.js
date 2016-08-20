require.config({
    baseUrl: "./node_modules",
    paths: {
        lib: "../lib",
        aquisitionsRules : "../aquisitionsRules/lib",
        root: "../",
        jquery: "jquery/dist/jquery.min",
        bootbox: "bootbox/bootbox.min"
    }
});

require(["root/index"]);
