<?php
require_once __DIR__ . '/../models/Report.php';

class ReportController {
    private $reportModel;

    public function __construct() {
        $this->reportModel = new Report();
    }

    public function dashboard() {
        $stats         = $this->reportModel->getGeneralStats();
        $recent_orders = $this->reportModel->getRecentOrders(5);
        $top_products  = $this->reportModel->getTopProducts(5);

        require_once BASE_PATH . '/views/admin/dashboard.php';
    }
}
?>