<?php
// Include your database configuration file
include_once ('../../../config.php');
session_start();

// Get data from the POST request for prenatal_subjective
$patient_id = $_POST['patient_id'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$temperature = $_POST['temperature'];
$pr = $_POST['pr'];
$rr = $_POST['rr'];
$bp = $_POST['bp'];
$menarche = $_POST['menarche'];
$lmp = $_POST['lmp'];
$gravida = $_POST['gravida'];
$para = $_POST['para'];
$fullterm = $_POST['fullterm'];
$preterm = $_POST['preterm'];
$abortion = $_POST['abortion'];
$stillbirth = $_POST['stillbirth'];
$alive = $_POST['alive'];
$hgb = $_POST['hgb'];
$ua = $_POST['ua'];
$vdrl = $_POST['vdrl'];
$nurse_id = $_POST['nurse_id'];
$date = date('Y-m-d');
$forceps_delivery = $_POST['forceps_delivery'];
$smoking = $_POST['smoking'];
$allergy_alcohol_intake = $_POST['allergy_alcohol_intake'];
$previous_cs = $_POST['previous_cs'];
$consecutive_miscarriage = $_POST['consecutive_miscarriage'];
$ectopic_pregnancy_h_mole = $_POST['ectopic_pregnancy_h_mole'];
$pp_bleeding = $_POST['pp_bleeding'];
$baby_weight_gt_4kgs = $_POST['baby_weight_gt_4kgs'];
$asthma = $_POST['asthma'];
$premature_contraction = $_POST['premature_contraction'];
$dm = $_POST['dm'];
$heart_disease = $_POST['heart_disease'];
$obesity = $_POST['obesity'];
$goiter = $_POST['goiter'];

// Sanitize input data
$patient_id = filter_var($patient_id, FILTER_SANITIZE_STRING);
$height = filter_var($height, FILTER_SANITIZE_STRING);
$weight = filter_var($weight, FILTER_SANITIZE_STRING);
$temperature = filter_var($temperature, FILTER_SANITIZE_STRING);
$pr = filter_var($pr, FILTER_SANITIZE_STRING);
$rr = filter_var($rr, FILTER_SANITIZE_STRING);
$bp = filter_var($bp, FILTER_SANITIZE_STRING);
$menarche = filter_var($menarche, FILTER_SANITIZE_STRING);
$lmp = filter_var($lmp, FILTER_SANITIZE_STRING);
$gravida = filter_var($gravida, FILTER_SANITIZE_STRING);
$para = filter_var($para, FILTER_SANITIZE_STRING);
$fullterm = filter_var($fullterm, FILTER_SANITIZE_STRING);
$preterm = filter_var($preterm, FILTER_SANITIZE_STRING);
$abortion = filter_var($abortion, FILTER_SANITIZE_STRING);
$stillbirth = filter_var($stillbirth, FILTER_SANITIZE_STRING);
$alive = filter_var($alive, FILTER_SANITIZE_STRING);
$hgb = filter_var($hgb, FILTER_SANITIZE_STRING);
$ua = filter_var($ua, FILTER_SANITIZE_STRING);
$vdrl = filter_var($vdrl, FILTER_SANITIZE_STRING);
$nurse_id = filter_var($nurse_id, FILTER_SANITIZE_STRING);
$forceps_delivery = filter_var($forceps_delivery, FILTER_SANITIZE_STRING);
$smoking = filter_var($smoking, FILTER_SANITIZE_STRING);
$allergy_alcohol_intake = filter_var($allergy_alcohol_intake, FILTER_SANITIZE_STRING);
$previous_cs = filter_var($previous_cs, FILTER_SANITIZE_STRING);
$consecutive_miscarriage = filter_var($consecutive_miscarriage, FILTER_SANITIZE_STRING);
$ectopic_pregnancy_h_mole = filter_var($ectopic_pregnancy_h_mole, FILTER_SANITIZE_STRING);
$pp_bleeding = filter_var($pp_bleeding, FILTER_SANITIZE_STRING);
$baby_weight_gt_4kgs = filter_var($baby_weight_gt_4kgs, FILTER_SANITIZE_STRING);
$asthma = filter_var($asthma, FILTER_SANITIZE_STRING);
$premature_contraction = filter_var($premature_contraction, FILTER_SANITIZE_STRING);
$dm = filter_var($dm, FILTER_SANITIZE_STRING);
$heart_disease = filter_var($heart_disease, FILTER_SANITIZE_STRING);
$obesity = filter_var($obesity, FILTER_SANITIZE_STRING);
$goiter = filter_var($goiter, FILTER_SANITIZE_STRING);

// Validate input data if necessary (Example: check if patient_id is not empty)


$sql_patient_id = "SELECT id FROM patients WHERE serial_no = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);
$stmt_patient_id->bind_param("s", $patient_id);
if ($stmt_patient_id->execute()) {
    $stmt_patient_id->bind_result($patient_id);
    if ($stmt_patient_id->fetch()) {
        // Now you have the patient_id
        $stmt_patient_id->close();

    } else {
        // Patient with the provided serial_no not found
        echo 'Error: Patient not found';
    }
} else {
    // Error executing the query
    echo 'Error: ' . $conn->error;
}

// Prepare and execute the SQL statement to insert into prenatal_subjective
$sql1 = "INSERT INTO prenatal_subjective (patient_id, height, weight, temperature, pr, rr, bp, menarche, lmp, gravida, para, fullterm, preterm, abortion, stillbirth, alive, hgb, ua, vdrl, forceps_delivery, smoking, allergy_alcohol_intake, previous_cs, consecutive_miscarriage, ectopic_pregnancy_h_mole, pp_bleeding, baby_weight_gt_4kgs, asthma, goiter, premature_contraction, obesity, heart_disease, checkup_date, doctor_id,nurse_id,dm) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param(
    "ssssssssssssssssssssssssssssssssssss",
    $patient_id,
    $height,
    $weight,
    $temperature,
    $pr,
    $rr,
    $bp,
    $menarche,
    $lmp,
    $gravida,
    $para,
    $fullterm,
    $preterm,
    $abortion,
    $stillbirth,
    $alive,
    $hgb,
    $ua,
    $vdrl,
    $forceps_delivery,
    $smoking,
    $allergy_alcohol_intake,
    $previous_cs,
    $consecutive_miscarriage,
    $ectopic_pregnancy_h_mole,
    $pp_bleeding,
    $baby_weight_gt_4kgs,
    $asthma,
    $goiter,
    $premature_contraction,
    $obesity,
    $heart_disease,
    $date,
    $doctor_id,
    $nurse_id,
    $dm
);


if ($stmt1->execute()) {
    // Get the last inserted ID
    $lastInsertedId = $conn->insert_id;

    // Get data from the POST request for prenatal_diagnosis
    $edc = $_POST['edc'];
    $aog = $_POST['aog'];
    $date_of_last_delivery = $_POST['date_of_last_delivery'];
    $place_of_last_delivery = $_POST['place_of_last_delivery'];
    $tt1 = $_POST['tt1'];
    $tt2 = $_POST['tt2'];
    $tt3 = $_POST['tt3'];
    $tt4 = $_POST['tt4'];
    $tt5 = $_POST['tt5'];

    // Checkboxes for prenatal_diagnosis
    $multiple_sex_partners = $_POST['multiple_sex_partners'];
    $unusual_discharges = $_POST['unusual_discharges'];
    $itching_sores_around_vagina = $_POST['itching_sores_around_vagina'];
    $tx_for_stis_in_the_past = $_POST['tx_for_stis_in_the_past'];
    $pain_burning_sensation = $_POST['pain_burning_sensation'];
    $ovarian_cyst = $_POST['ovarian_cyst'];
    $myoma_uteri = $_POST['myoma_uteri'];
    $placenta_previa = $_POST['placenta_previa'];
    $still_birth = $_POST['still_birth'];
    $pre_eclampsia = $_POST['pre_eclampsia'];
    $eclampsia = $_POST['eclampsia'];
    $hpn = $_POST['hpn'];
    $uterine_myomectomy = $_POST['uterine_myomectomy'];
    $thyroid_disorder = $_POST['thyroid_disorder'];
    $epilepsy = $_POST['epilepsy'];
    $height_less_than_145cm = $_POST['height_less_than_145cm'];
    $family_history_gt_36cm = $_POST['family_history_gt_36cm'];



    $sql7 = "INSERT INTO prenatal_consultation (prenatal_consultation_id,patient_id,midwife_id,checkup_date)
    VALUES (?,?,?,?)";
    $stmt7 = $conn->prepare($sql7);
    $stmt7->bind_param("dsss", $last_inserted_id, $patient_id, $nurse_id, $date);
    $stmt7->execute();

    // Prepare and execute the SQL statement to insert into prenatal_diagnosis
// Prepare and execute the SQL statement to insert into prenatal_diagnosis
    $sql2 = "INSERT INTO prenatal_diagnosis (prenatal_subjective_id, patient_id, edc, aog, date_of_last_delivery, place_of_last_delivery, tt1, tt2, tt3, tt4, tt5, multiple_sex_partners, unusual_discharges, itching_sores_around_vagina, tx_for_stis_in_the_past, pain_burning_sensation, ovarian_cyst, myoma_uteri, placenta_previa, still_birth, pre_eclampsia, eclampsia, premature_contraction, hpn, uterine_myomectomy, thyroid_disorder, epilepsy, height_less_than_145cm, family_history_gt_36cm) 
VALUES (?, ?, ?, ?, ?,  ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,    ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,  ?, ?, ?, ?)";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param(
        "dssssssssssssssssssssssssssss",
        $lastInsertedId,
        $patient_id,
        $edc,
        $aog,
        $date_of_last_delivery,
        $place_of_last_delivery,
        $tt1,
        $tt2,
        $tt3,
        $tt4,
        $tt5,
        $multiple_sex_partners,
        $unusual_discharges,
        $itching_sores_around_vagina,
        $tx_for_stis_in_the_past,
        $pain_burning_sensation,
        $ovarian_cyst,
        $myoma_uteri,
        $placenta_previa,
        $still_birth,
        $pre_eclampsia,
        $eclampsia,
        $premature_contraction,
        $hpn,
        $uterine_myomectomy,
        $thyroid_disorder,
        $epilepsy,
        $height_less_than_145cm,
        $family_history_gt_36cm
    );


    if ($stmt2->execute()) {
        // Successful insertion for prenatal_diagnosis
        echo 'Success';
    } else {
        // Error handling for prenatal_diagnosis
        echo 'Error: ' . $conn->error;
    }

    // Close the database connection for prenatal_diagnosis
    $stmt2->close();
} else {
    // Error handling for prenatal_subjective
    echo 'Error: ' . $conn->error;
}

// Close the database connection for prenatal_subjective
$stmt1->close();
$conn->close();
?>