                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $diterima = 'diterima';
                                        $query = "SELECT * FROM sts_daftar WHERE kd_daftar = ? and acc_role = ? LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("is", $kd_daftar, $acc_role_wakil_rektor);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <div class="timeline-block">
                                                    <span class="timeline-step badge-<?php $wakil_rektor_status = $row['status'];
                                                                                        echo ($wakil_rektor_status == "diterima" ? "success" : "danger") ?>">
                                                        <i class="fas fa-<?php $wakil_rektor_status = $row['status'];
                                                                            echo ($wakil_rektor_status == "diterima" ? "check" : "exclamation") ?>"></i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <span class="badge badge-pill badge-<?php $wakil_rektor_status = $row['status'];
                                                                                            echo ($wakil_rektor_status == "diterima" ? "success" : "danger") ?>"><?php echo $row['status']; ?></span>
                                                        <h5 class=" mt-3 mb-0">Seleksi Beasiswa </h5>

                                                        <div class="mt-3">
                                                            <small class="text-muted font-weight-bold"><?php $date = $row['acc_tanggal'];
                                                                                                        echo date('d-m-Y g:i A', strtotime($date)); ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-warning">
                                                    <i class="fas fa-history"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-warning">DIPROSES</span>
                                                    <h5 class=" mt-3 mb-0">Seleksi Beasiswa</h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold">00-00-0000 00:00 --</small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>