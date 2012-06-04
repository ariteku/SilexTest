
function onClickCreate() {

	console.log("#log id=" + $("#id").val() + ", text=" + $("#text").val());
	create({
		"id": $("#id").val(),
		"text": $("#text").val()
	});

}

function create(param) {

	/*
	var result = confirm("データを作成します");
	if(!result) {
		return;
	}
	*/
	$.ajax({
		cache: false,
		type: "POST",
		url: "/create/json",
		data: param,
		timeout: 7000,
		dataType:"json",
		beforeSend: function() {
			// alert("通信するよー");
		},
		complete: function() {
			// alert("通信おわたー");
		},
		success: function(data){
			if(data.status === "successful") {
				// なんか色々やろう
				createColumn(param);
			} else {
				alert("作成に失敗しました");
			}
		},
		error: function(){
			alert("サーバーとかネットワークとか確認してくださいな");
		}
	});
}

function deleteById(id) {
	
	var result = confirm("本当に削除しますか？");
	if(!result) {
		return;
	}
	$.ajax({
		cache: false,
		type: "POST",
		url: "/delete/json",
		data: {"id": id},
		timeout: 7000,
		dataType:"json",
		beforeSend: function() {
			// alert("通信するよー");
		},
		complete: function() {
			// alert("通信おわたー");
		},
		success: function(data){
			if(data.status === "successful") {
				deleteColumn(id);
			} else {
				alert("削除に失敗しました");
			}
		},
		error: function(){
			alert("サーバーとかネットワークとか確認してくださいな");
		}
	});
}

function deleteColumn(id) {
	$("#itemid" + id).remove();	
}

function createColumn(param) {

	var html = "<tr id='itemid" + param.id + "'>";
	html += "<td>" + param.id + "</td>";
	html += "<td>" + param.text + "</td>";
	html += "<td>";
	html += "	<a href=javascript:deleteById('" + param.id + "');>delete</a>";
	// html += " | <a href=javascript:onClickUpdatei('" + param.id + "');>update</a>";
	html += "</td>";
	
	$("#table").append(html);

}

