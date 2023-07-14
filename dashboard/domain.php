<?php
include('template/header.php');
?>

<!-- Container-fluid starts-->
<div class="container">
    <div class="row starter-main">
        <div class="col-sm-12">
            <div class="card-status">
                <div class="text-center">
                    <h5 class="card-title mb-4">Domain For Short</h5>
                </div>
                <div class="col-lg-12">
                    <div class="input-group">
                        <input name="domain_short" class="form-control btn-square" placeholder="Add Short domain" type="text">
                        <button id="domainshort" type="button" class="input-group-text btn btn-primary btn-right"><i class="icon-plus"></i> Add
                        </button>
                    </div>
                </div>
                <hr>
                <table id="domain-tables" class="table  table-hover">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Ping Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $domains = getDomainshort();
                        foreach ($domains as $row) {
                            $domain = $row['domain'];
                            $idDomain =  $row['iddomain_short'];
                            $ping = ping($domain, 80, 10);
                            if ($ping == 'down') {
                                $status = '<span class="badge bg-danger"><i class="icon-bar-chart"></i> DOWN</span>';
                            } else {
                                $status = '<span class="badge bg-success"><i class="icon-bar-chart"></i> ' . $ping . '</span>';
                            }
                        ?>
                            <tr>
                                <td><a style="text-decoration:none; color:black;" target="_blank" href="https://<?= $domain ?>"><?= $domain ?></a></td>
                                <td><?= $status ?></td>
                                <td>
                                    <button id="<?= $idDomain ?>" class="btn btn-danger btn-sm genit"><i class="icon-trash"></i>
                                        Delete</button>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
<?php

include('template/footer.php');

?>