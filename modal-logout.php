<!-- Modal logout -->
<div class="modal fade" id="Logout" tabindex="-1" aria-labelledby="LogoutLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="LogoutLabel">Logout</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php
            if (isset($_GET['message']) && $_GET['modal'] === 'room') {
                $alert_class = $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger';
                echo "<div class='alert $alert_class mx-5 mt-2'>" . htmlspecialchars($_GET['message']) . "</div>";
            }
            ?>
            <form action="admin.php" method="POST">
                <div class="modal-body">
                    <div class="row-4">
                        <div class="col">
                            <h6>คุณต้องการจะออกจากระบบใช่หรือไม่</h6>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    <a href="admin.php?logout='1'" class="btn btn-danger " name="btn-logout-logout">Logout</a>
                </div>
            </form>
        </div>
    </div>
</div>