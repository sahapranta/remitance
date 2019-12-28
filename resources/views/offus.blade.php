@extends('layouts.app') @section('css')
<script>
    function format_result(arr) {
        let info = [];
        Object.entries(arr).map(element => {
            let obj = [];
            element[1].split(/[\s;\t\n]+/).map(d => {
                if (
                    d !== "PRINCIPAL" &&
                    d !== "Sundry" &&
                    d !== "Debtor" &&
                    d !== "O" &&
                    d !== "TT" &&
                    d !== "DR" &&
                    d !== "BDT" &&
                    d !== " " &&
                    d !== "." &&
                    d !== "FT" &&
                    d !== "Govt.Impress" &&
                    d !== "Fu"
                ) {
                    obj.push(d);
                }
            });
            if (!obj[2].startsWith("BDT")) {
                let index = obj.length - 2;
                let sp = obj[index].split("F");
                info.push({
                    code: obj[2],
                    amount: parseFloat(sp[0].replace(/[^0-9 | ^.]/g, "")),
                    ref: `F${sp[1]}`,
                    name: obj.slice(3, index).join(" ")
                });
            }
        });
        info.sort((a, b) => a.name.localeCompare(b.name));
        return info;
    }

    function upload(e) {
        e.preventDefault();
        if (
            !$(e.target.form)
                .find(":file")
                .val()
        ) {
            mconfirm("Please Select File!");
        } else {
            let date = $(e.target.form)
                .find('input[type="date"]')
                .val();
            let data = new FormData(e.target.form);
   
            const config = {
                onUploadProgress: function(progressEvent) {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    $('.progress-bar').html(`${percentCompleted}%`);
                    $('.progress-bar').css({'width': `${percentCompleted}%`});
                }
            }

            axios
                .post(e.target.form.action, data, config)
                .then(res => {
                    let rem = format_result(res.data.rem);
                    let inc = format_result(res.data.inc);

                    let both = rem.map((r, i) => {
                        let temp = inc.find(el => el.code === r.code);
                        if (temp && temp.amount) {
                            r.incentive = temp.amount;
                        } else {
                            r.incentive = 0;
                        }
                        return r;
                    });
                    
                    axios
                        .post(`${e.target.form.action}/create`, {
                            date,
                            data: both
                        })
                        .then(res => {
                            if (res.data === 'true') {
                                mconfirm("Data Submitted Successfully");
                            } else {
                                mconfirm(res.data);
                            }
                        })
                        .catch(err => console.log(err));
                })
                .catch(err => console.log(err));
        }
    }
    window.onload = function() {
        var isAdvancedUpload = (function() {
            var div = document.querySelector("#offus_drag");
            return (
                ("draggable" in div ||
                    ("ondragstart" in div && "ondrop" in div)) &&
                "FormData" in window &&
                "FileReader" in window
            );
        })();

        if (isAdvancedUpload) {
            $("#offus_drag")
                .on(
                    "drag dragstart dragend dragover dragenter dragleave drop",
                    function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                )
                .on("dragover dragenter", function() {
                    $(this).addClass("shadow border-success");
                })
                .on("dragleave dragend drop", function() {
                    $(this).removeClass("shadow border-success");
                })
                .on("drop", function(e) {
                    let droppedFiles = e.originalEvent.dataTransfer.files;
                    $(this)
                        .find(":file")
                        .prop("files", droppedFiles);
                });
        }
    };
</script>
@endsection @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card" id="offus_drag">
                <div class="card-header">Upload Offus File</div>
                <div class="card-body">                   
                    <form
                        action="{{ route('offus.upload') }}"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="form-group">
                            <input
                                type="date"
                                class="form-control"
                                name="date"
                                value="{{ date('Y-m-d') }}"
                            />
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-sm">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="remitance"
                                    value="BDT1266000014006"
                                />
                                <input
                                    type="text"
                                    class="form-control"
                                    name="incentive"
                                    value="BDT1266100014006"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <input
                                type="file"
                                class="form-control"
                                name="file"
                                accept=".txt"
                            />
                        </div>
                        <button
                            onclick="upload(event)"
                            class="btn btn-block btn-outline-danger"
                        >
                            Upload
                        </button>
                    </form>
                    <div class="progress mt-3">
                        <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
