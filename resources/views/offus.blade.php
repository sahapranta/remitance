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
                    ref:sp[1],
                    name: obj.slice(3, index).join(" ")
                });
            }
        });
        info.sort((a, b) => a.name.localeCompare(b.name))
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
                .val()
            let data = new FormData(e.target.form);

            axios
                .post(e.target.form.action, data)
                .then(res => {
                    let rem = format_result(res.data.rem);
                    let inc = format_result(res.data.inc);

                    let both = rem.map((r, i)=>{
                        let temp = inc.find(el=>el.code === r.code);
                        if (temp && temp.amount) {
                            r.incentive = temp.amount;
                        } else {
                            r.incentive = 0;
                        }
                        return r;
                    });

                    axios.post(`${e.target.form.action}/create`, {date, data: both})
                    .then(res =>{
                        if (res.data) {
                            mconfim('Data Submitted Successfully');
                        }
                    })
                    .catch(err => console.log(err));

                })
                .catch(err => console.log(err));
        }
    }
    window.onload = function() {};
</script>
@endsection @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Upload Offus File</div>
                <div class="card-body">
                    <form
                        action="{{ route('offus.upload') }}"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="form-group">
                            <input type="date" class="form-control" name="date" value="{{date('Y-m-d')}}">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
