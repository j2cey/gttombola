$('#tags').select2({
	tags: true,
    data: ["Systeme","Type Article","Article"],
    tokenSeparators: [','],
    placeholder: "Ajouter des tags",
    /* the next 2 lines make sure the user can click away after typing and not lose the new tag */
    selectOnClose: true,
    closeOnSelect: false
});
