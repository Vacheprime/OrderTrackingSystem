<?php

namespace App\Http\Controllers;

use app\Doctrine\ORM\Entity\Order;
use app\Doctrine\ORM\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class TrackingController extends Controller
{
    protected EntityManager $entityManager;
    protected OrderRepository $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = ($entityManager->getRepository(Order::class));
    }
    public function tracking() {
        return view("tracking.order-input");
    }

    public function track(Request $request) {
        $validatedData = $request->validate([
            "reference-number" => 'required|string'
        ]);
        $errors = [];
        if ($this->repository->findByReferenceNumber($validatedData["reference-number"]) == null) {
            $error["reference-number"] = "This Reference Number does not exist.";
        }
        if (!isEmpty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }
        $trackingNumber = $validatedData["reference-number"];
        return redirect("/tracking/display?trackingNumber=$trackingNumber");
    }
    public function display(Request $request) {
        $referenceNumber = $request->input("trackingNumber");
        $order = $this->repository->findByReferenceNumber($referenceNumber);
        return view("tracking.order-display")->with(compact("order"));
    }
}
