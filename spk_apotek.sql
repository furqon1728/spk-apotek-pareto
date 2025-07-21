DROP DATABASE IF EXISTS spk_apotek;

create database spk_apotek;

use spk_apotek;

create table obat(
kode_obat varchar(20) primary key,
nama_obat varchar(100),
sediaan enum('Tablet', 'Kapsul', 'Pil', 'Serbuk', 'Salep', 'Krim', 'Gel', 'Sirup', 'Suspensi', 'Injeksi', 'Infus', 'Tetes', 'Inhalasi', 'Aerosol'),
harga int
);

INSERT INTO obat(kode_obat, nama_obat, sediaan, harga) VALUES
-- SALAP
('SAL001','CENDO MYCOS TM 5 mL','Salep','28000'),
('SAL002','OCTENILIN GEL 10 gram','Salep','40000'),
('SAL003','BEPANTHEN OINT 20 gram','Salep','81000'),
('SAL004','ZUDAIFU SALEP 15 gram','Salep','15000'),
('SAL005','KALPANAX CRM 10GR KLBE 1 Pcs','Salep','31000'),
('SAL006','VITAQUIN 2% (MELANOX) 15 gram','Salep','41000'),
('SAL007','COUNTERPAIN COOL 15GR BRISTOL 1 Pcs','Salep','33000'),
('SAL008','CERADAN BARRIER CR 30GR 1 Pcs','Salep','174000'),
('SAL009','COUNTERPAIN 60 GR 1 Pcs','Salep','84000'),
('SAL010','PURE KIDS ITCHY CR 15 GR 1 Pcs','Salep','31000'),
('SAL011','PURE MOM NIPPLE CR 1 Pcs','Salep','85000'),
('SAL012','BURNAZIN CR 35GR 1 Pcs','Salep','92000'),
('SAL013','ALOCLAIR PLUS GEL 8ML 1 Pcs','Salep','113000'),
('SAL014','MEFUROSAN CREAM 10GR 1 Pcs','Salep','105000'),
('SAL015','VOLTADEX GEL 1% 20GR 1 Pcs','Salep','28000'),
('SAL016','TONG KANG SHUANG CR 1 Pcs','Salep','11000'),
('SAL017','KLODERMA OINT 10GR 1 Pcs','Salep','47000'),
('SAL018','HANSAPLAST SALEP LUKA 20G 1 Pcs','Salep','50000'),
('SAL019','GENTASOLON CR 5 GR 1 Pcs','Salep','34000'),
('SAL020','VITAQUIN 5% 15 gram','Salep','88000'),
('SAL021','KLODERMA CR 5GR 1 Pcs','Salep','30000'),
('SAL022','BEBITHEN KRIM 1 Pcs','Salep','51000'),
('SAL023','KETOCONAZOLE CR 2% 1 Pcs','Salep','10000'),
('SAL024','SRITI CREAM 1 Pcs','Salep','12000'),
('SAL025','NISAGON CR 5GR 1 Pcs','Salep','8000'),
('SAL026','NOROID DERMA RASH CREAM 60ML 1 Pcs','Salep','210000'),
('SAL027','DIPROGENTA CR 10 GR 1 Pcs','Salep','127339'),
('SAL028','MUPIROCIN OINT 10 GR 1 Pcs','Salep','40000'),
('SAL029','COUNTERPAIN 120GR 1 Pcs','Salep','125000'),
('SAL030','SALONPAS GEL 15GR 1 Pcs','Salep','16000'),

-- TABLET
('TAB001','PARACETAMOL 500MG','Tablet','5000'),
('TAB002','OBAT MAAG TABLET','Tablet','6000'),
('TAB003','METFORMIN 500MG','Tablet','7000'),
('TAB004','AMLODIPINE 5MG','Tablet','8000'),
('TAB005','IBUPROFEN 400MG','Tablet','9500'),

-- KAPSUL
('KAP001','OMEPRAZOLE 20MG','Kapsul','9000'),
('KAP002','DOKSISIKLIN 100MG','Kapsul','8500'),
('KAP003','VITAMIN E 400IU','Kapsul','15000'),
('KAP004','BODREXIN KAPSUL','Kapsul','9500'),
('KAP005','FLUCLOXACILLIN 250MG','Kapsul','8700'),

-- PIL
('PIL001','PIL KB ANDALAN','Pil','8000'),
('PIL002','PIL ANTI NYERI','Pil','9500'),
('PIL003','PIL PENAMBAH DARAH','Pil','12000'),
('PIL004','PIL FLU & BATUK','Pil','10000'),
('PIL005','PIL ANTASIDA','Pil','9000'),

-- SERBUK
('SER001','TALCUM POWDER 100GR','Serbuk','11000'),
('SER002','ORALIT SERBUK','Serbuk','4000'),
('SER003','ANTANGIN JRG','Serbuk','3000'),
('SER004','SUSU BUBUK VIT D','Serbuk','25000'),
('SER005','SARI KURMA BUBUK','Serbuk','18000'),

-- KRIM
('KRM001','CLOTRIMAZOLE CREAM 10 GR','Krim','15000'),
('KRM002','VITAQUIN 2% CREAM','Krim','41000'),
('KRM003','SRITI CREAM','Krim','12000'),
('KRM004','BEBITHEN CREAM','Krim','51000'),
('KRM005','PAINKILA CREAM','Krim','30000'),

-- GEL
('GEL001','MEDI-KLIN GEL 15 GR','Gel','34000'),
('GEL002','ALOCLAIR PLUS GEL','Gel','113000'),
('GEL003','VERILE ACNE GEL','Gel','19000'),
('GEL004','NIACEF GEL','Gel','43000'),
('GEL005','CENTABIO GEL','Gel','34000'),

-- SIRUP
('SIR001','OBH COMBI SYRUP 100ML','Sirup','19000'),
('SIR002','MUCOLYTE SYRUP','Sirup','16000'),
('SIR003','PARACETAMOL SYRUP','Sirup','18000'),
('SIR004','VITAMIN C SYRUP','Sirup','17000'),
('SIR005','FLUCOLD SYRUP','Sirup','15000'),

-- SUSPENSI
('SUS001','AMOXICILLIN SUSPENSION 60ML','Suspensi','17000'),
('SUS002','CEFADROXIL SUSPENSION','Suspensi','21000'),
('SUS003','FLUDEKS SUSPENSION','Suspensi','15000'),
('SUS004','ACETYLCYSTEINE SUSPENSION','Suspensi','22000'),
('SUS005','COTRIMOXAZOLE SUSPENSION','Suspensi','12000'),

-- INJEKSI
('INJ001','CENDO XYLOCAIN INJ 2ML','Injeksi','45000'),
('INJ002','DEXAMETHASONE INJEKSI','Injeksi','30000'),
('INJ003','VIT B COMPLEX INJ','Injeksi','28000'),
('INJ004','RANITIDINE INJEKSI','Injeksi','26000'),
('INJ005','KETOROLAC INJEKSI','Injeksi','32000'),

-- TETES
('TET001','CENDO XITROL EYE DROP 5ML','Tetes','48000'),
('TET002','CENDO MYCOS EYE DROP','Tetes','35000'),
('TET003','OBAT TETES TELINGA','Tetes','15000'),
('TET004','OBAT TETES HIDUNG','Tetes','12000'),
('TET005','TETES MATA INSTO','Tetes','10000');

-- alter table krs
-- add foreign key (mahasiswa_npm) references mahasiswa(npm),
-- add foreign key (matakuliah_kodemk) references matakuliah(kodemk);
