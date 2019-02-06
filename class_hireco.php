<?php

#############################
# Global Functions

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

# Global Functions
#############################
# Start Functions

class hireco {

function init ($params){

 global $funky;

 $profile_id = $params['profile_id'];
 $bodypart_id = $params['bodypart_id'];
 $genetics = $params['genetics'];
 $mother = $params['mother'];
 $origin = $params['origin'];
 $sub_origin = $params['sub_origin'];
 $target = $params['target'];
 $sub_target = $params['sub_target'];
 $stimuli = $params['stimuli'];
 $stimuli_strength = $params['stimuli_strength'];

 $now = date("Y-m-d H:i:s");

 $record_params[0] = "/var/www/vhosts/scalastica.com/httpdocs";
 $record_params[1] = "hireco";

 $hash_string = $now.$bodypart_id.$origin.$sub_origin.$target.$sub_target.$stimuli;

 # $hireco_hash = $funky->encryptor ($hash_params);
 $hireco_hash = hash('md5', $hash_string);

 # Get profile data - contains all initial genetic data and accumulated data over the organism's life

 $birthdate = '1972-07-05';
 $gender = 'male';

 # Gender - all factors should be calculated differently based on gender

 if (!$gender){
    $gender = "male";
    }

 # Calculate Age

 $date1 = date_create($birthdate);
 $date2 = date_create($now);
 $diff = date_diff($date1,$date2);
 $age = $diff->format("%a");

 $hireco_package['event_id'] = $hireco_hash;
 $hireco_package['profile_id'] = $profile_id;
 $hireco_package['genetics'] = $genetics;
 $hireco_package['mother'] = $mother;
 $hireco_package['birthdate'] = $birthdate;
 $hireco_package['datetime'] = $now;
 $hireco_package['age'] = $age;
 $hireco_package['gender'] = $gender;
 $hireco_package['bodypart_id'] = $bodypart_id;
 $hireco_package['origin'] = $origin;
 $hireco_package['sub_origin'] = $sub_origin;
 $hireco_package['target'] = $target;
 $hireco_package['sub_target'] = $sub_target;
 $hireco_package['stimuli'] = $stimuli;
 $hireco_package['stimuli_strength'] = $stimuli_strength;

 #$content_hireco_package = json_encode($hireco_package);
 #$record_params[2] = $content_hireco_package;
 #$this->event_recorder ($record_params);

 # Get accumulated surregate data if available for this profile
 # If none exists, rely on assumtions

/*

Conception to Birth

0	Days	0	Weeks	0.00	Months	0.00	Years	0	0	Hours
7	Days	1	Weeks	0.25	Months	0.02	Years	7	168	Hours
14	Days	2	Weeks	0.50	Months	0.04	Years	14	336	Hours
21	Days	3	Weeks	0.75	Months	0.06	Years	21	504	Hours
28	Days	4	Weeks	1.00	Months	0.08	Years	28	672	Hours
35	Days	5	Weeks	1.25	Months	0.10	Years	35	840	Hours
42	Days	6	Weeks	1.50	Months	0.12	Years	42	1,008	Hours
49	Days	7	Weeks	1.75	Months	0.13	Years	49	1,176	Hours
56	Days	8	Weeks	2.00	Months	0.15	Years	56	1,344	Hours
63	Days	9	Weeks	2.25	Months	0.17	Years	63	1,512	Hours
70	Days	10	Weeks	2.50	Months	0.19	Years	70	1,680	Hours
77	Days	11	Weeks	2.75	Months	0.21	Years	77	1,848	Hours
84	Days	12	Weeks	3.00	Months	0.23	Years	84	2,016	Hours
91	Days	13	Weeks	3.25	Months	0.25	Years	91	2,184	Hours
98	Days	14	Weeks	3.50	Months	0.27	Years	98	2,352	Hours
105	Days	15	Weeks	3.75	Months	0.29	Years	105	2,520	Hours
112	Days	16	Weeks	4.00	Months	0.31	Years	112	2,688	Hours
119	Days	17	Weeks	4.25	Months	0.33	Years	119	2,856	Hours
126	Days	18	Weeks	4.50	Months	0.35	Years	126	3,024	Hours
133	Days	19	Weeks	4.75	Months	0.36	Years	133	3,192	Hours
140	Days	20	Weeks	5.00	Months	0.38	Years	140	3,360	Hours
147	Days	21	Weeks	5.25	Months	0.40	Years	147	3,528	Hours
154	Days	22	Weeks	5.50	Months	0.42	Years	154	3,696	Hours
161	Days	23	Weeks	5.75	Months	0.44	Years	161	3,864	Hours
168	Days	24	Weeks	6.00	Months	0.46	Years	168	4,032	Hours
175	Days	25	Weeks	6.25	Months	0.48	Years	175	4,200	Hours
182	Days	26	Weeks	6.50	Months	0.50	Years	182	4,368	Hours
189	Days	27	Weeks	6.75	Months	0.52	Years	189	4,536	Hours
196	Days	28	Weeks	7.00	Months	0.54	Years	196	4,704	Hours
203	Days	29	Weeks	7.25	Months	0.56	Years	203	4,872	Hours
210	Days	30	Weeks	7.50	Months	0.58	Years	210	5,040	Hours
217	Days	31	Weeks	7.75	Months	0.59	Years	217	5,208	Hours
224	Days	32	Weeks	8.00	Months	0.61	Years	224	5,376	Hours
231	Days	33	Weeks	8.25	Months	0.63	Years	231	5,544	Hours
238	Days	34	Weeks	8.50	Months	0.65	Years	238	5,712	Hours
245	Days	35	Weeks	8.75	Months	0.67	Years	245	5,880	Hours

0	Days	36	Weeks	9.00	Months	0.00	Years	252	6,048	Hours

Birth to one year - with real days since conception = days alive

7	Days	37	Weeks	9.25	Months	0.02	Years	259	6,216	Hours
14	Days	38	Weeks	9.50	Months	0.04	Years	266	6,384	Hours
21	Days	39	Weeks	9.75	Months	0.06	Years	273	6,552	Hours
28	Days	40	Weeks	10.00	Months	0.08	Years	280	6,720	Hours
35	Days	41	Weeks	10.25	Months	0.10	Years	287	6,888	Hours
42	Days	42	Weeks	10.50	Months	0.12	Years	294	7,056	Hours
49	Days	43	Weeks	10.75	Months	0.13	Years	301	7,224	Hours
56	Days	44	Weeks	11.00	Months	0.15	Years	308	7,392	Hours
63	Days	45	Weeks	11.25	Months	0.17	Years	315	7,560	Hours
70	Days	46	Weeks	11.50	Months	0.19	Years	322	7,728	Hours
77	Days	47	Weeks	11.75	Months	0.21	Years	329	7,896	Hours
84	Days	48	Weeks	12.00	Months	0.23	Years	336	8,064	Hours
91	Days	49	Weeks	12.25	Months	0.25	Years	343	8,232	Hours
98	Days	50	Weeks	12.50	Months	0.27	Years	350	8,400	Hours
105	Days	51	Weeks	12.75	Months	0.29	Years	357	8,568	Hours
112	Days	52	Weeks	13.00	Months	0.31	Years	364	8,736	Hours
119	Days	53	Weeks	13.25	Months	0.33	Years	371	8,904	Hours
126	Days	54	Weeks	13.50	Months	0.35	Years	378	9,072	Hours
133	Days	55	Weeks	13.75	Months	0.36	Years	385	9,240	Hours
140	Days	56	Weeks	14.00	Months	0.38	Years	392	9,408	Hours
147	Days	57	Weeks	14.25	Months	0.40	Years	399	9,576	Hours
154	Days	58	Weeks	14.50	Months	0.42	Years	406	9,744	Hours
161	Days	59	Weeks	14.75	Months	0.44	Years	413	9,912	Hours
168	Days	60	Weeks	15.00	Months	0.46	Years	420	10,080	Hours
175	Days	61	Weeks	15.25	Months	0.48	Years	427	10,248	Hours
182	Days	62	Weeks	15.50	Months	0.50	Years	434	10,416	Hours
189	Days	63	Weeks	15.75	Months	0.52	Years	441	10,584	Hours
196	Days	64	Weeks	16.00	Months	0.54	Years	448	10,752	Hours
203	Days	65	Weeks	16.25	Months	0.56	Years	455	10,920	Hours
210	Days	66	Weeks	16.50	Months	0.58	Years	462	11,088	Hours
217	Days	67	Weeks	16.75	Months	0.59	Years	469	11,256	Hours
224	Days	68	Weeks	17.00	Months	0.61	Years	476	11,424	Hours
231	Days	69	Weeks	17.25	Months	0.63	Years	483	11,592	Hours
238	Days	70	Weeks	17.50	Months	0.65	Years	490	11,760	Hours
245	Days	71	Weeks	17.75	Months	0.67	Years	497	11,928	Hours
252	Days	72	Weeks	18.00	Months	0.69	Years	504	12,096	Hours
259	Days	73	Weeks	18.25	Months	0.71	Years	511	12,264	Hours
266	Days	74	Weeks	18.50	Months	0.73	Years	518	12,432	Hours
273	Days	75	Weeks	18.75	Months	0.75	Years	525	12,600	Hours
280	Days	76	Weeks	19.00	Months	0.77	Years	532	12,768	Hours
287	Days	77	Weeks	19.25	Months	0.79	Years	539	12,936	Hours
294	Days	78	Weeks	19.50	Months	0.81	Years	546	13,104	Hours
301	Days	79	Weeks	19.75	Months	0.82	Years	553	13,272	Hours
308	Days	80	Weeks	20.00	Months	0.84	Years	560	13,440	Hours
315	Days	81	Weeks	20.25	Months	0.86	Years	567	13,608	Hours
322	Days	82	Weeks	20.50	Months	0.88	Years	574	13,776	Hours
329	Days	83	Weeks	20.75	Months	0.90	Years	581	13,944	Hours
336	Days	84	Weeks	21.00	Months	0.92	Years	588	14,112	Hours
343	Days	85	Weeks	21.25	Months	0.94	Years	595	14,280	Hours
350	Days	86	Weeks	21.50	Months	0.96	Years	602	14,448	Hours
357	Days	87	Weeks	21.75	Months	0.98	Years	609	14,616	Hours
364	Days	88	Weeks	22.00	Months	1.00	Years	616	14,784	Hours

*/

 switch ($age){

  # The span between each age range will increase over time as changes will slow down

  case 0:

   # Conception

   $hireco_package = $this->conception ($hireco_package);
  
  break;
  case ($age > 0 && $age <= 7):

   # Zygote - 1 to 7 days

   $hireco_package = $this->zygote ($hireco_package);
  
  break;
  case ($age > 7 && $age <= 49):

   # Embryo 7 to 49 days

   # Up to 33 Days - posterior (epithalamic) commissure appears
   # Up to 33 Days - medial forebrain bundle appears

   $hireco_package = $this->embryo ($hireco_package);

  break;
  case ($age > 49 && $age <= 252):

   # Foetus - 49 to 252 days

   # 70 Days = 10 Weeks
   # By th tenth week of gestational age the embryo has acquired its basic form

   $hireco_package = $this->foetus ($hireco_package);

  break;
  case ($age == 252):

   # Birthday

   $hireco_package = $this->birth ($hireco_package);

  break;
  case ($age > 252 && $age <= 616):

   # Infant - Birth to 1 Year

   $hireco_package = $this->infant ($hireco_package);

  break; 
  case ($age > 616 && $age <= 4991):

   # Child - 1 to 12.99 Years

   $hireco_package = $this->child ($hireco_package);

  break; 
  case ($age > 4991 && $age <= 7546):

   # Teen - 13 to 19.98 years

   $hireco_package = $this->teen ($hireco_package);

  break; 
  case ($age > 7546 && $age <= 36505):

   # Adult - 20 to 100 years

   $hireco_package = $this->adult ($hireco_package);

  break; 

  } # end switch

 $content_hireco_package = json_encode($hireco_package);
 #$hireco_package = serialize($hireco_package);

 $record_params[2] = $content_hireco_package;

 $this->event_recorder ($record_params);

 return $hireco_package;

} # end Hireco init

# End Hireco
##################################
# Conception

function conception ($params){

 $event_id = $hireco_package['event_id'];
 $profile_id = $hireco_package['profile_id'];
 $datetime  = $hireco_package['datetime'];
 $mother = $hireco_package['mother'];
 $genetics = $hireco_package['genetics'];
 $age = $hireco_package['age'];
 $birthdate = $hireco_package['birthdate'];
 $gender = $hireco_package['gender'];
 $bodypart_id = $hireco_package['bodypart_id'];
 $origin = $hireco_package['origin'];
 $sub_origin = $hireco_package['sub_origin'];
 $target = $hireco_package['target'];
 $sub_target = $hireco_package['sub_target'];
 $stimuli = $hireco_package['stimuli'];
 $stimuli_strength = $hireco_package['stimuli_strength'];
 $brain_pack = $hireco_package['brain'];
 $body_pack = $hireco_package['body'];

 switch ($age){

  case 0:

   /*

   Day 0

   Conception - Fertilisation

   https://www.youtube.com/watch?v=aBxzHqpI0YQ
 
   Receive the male and female chromosomes and fuse them to create the new genetic version!

   The result of this collision will be the zygote, like the oocyte, which is encased by its protective covering, the zona pellucida, and contains 46 unique chromosomes with the entire genetic blueprint of a new individual. 

   Humans have 23 distinct types of chromosomes, the 22 autosomes and the special category of sex chromosomes. There are two distinct sex chromosomes, the X chromosome and the Y chromosome.

   Chromosomes contain tightly packed, tightly coiled molecules called DNA.

   1. The sperm cell unpacks its tightly-packed genetic material
   2. Genetic material spreads out and elongates
   3. A new membrane forms around the genetic material, creating the male pronucleus
   4. Genetic material reforms into 23 chromosomes
   5. The female genetic material follows similarly
   6. As the pronucli forms, microtubial threads extend out and connect to them
   7. The microtubials pull the pronucli together
   8. The two sets of pronucli join and the chromosomes combine, completing fertilisation
   9. A unique genetic code arises from the two sets creating one cell of 46 chromosomes - the zygote

   */
   $male_genetics = $genetics['male'];
   $male_chromosomes = $male_genetics['chromosomes'];

   $female_genetics = $genetics['female'];
   $female_chromosomes = $female_genetics['chromosomes'];

   $mother_avg_heart_rate = $mother['avg_heart_rate'];

   $brain_package = $this->brain ($brain_params);
   $body_package = $this->body ($body_params);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 

 } # end age switch 

 return $hireco_package;

} # Conception

# Conception
##################################
# Zygote

function zygote ($hireco_package){

 $event_id = $hireco_package['event_id'];
 $profile_id = $hireco_package['profile_id'];
 $datetime  = $hireco_package['datetime'];
 $mother = $hireco_package['mother'];
 $genetics = $hireco_package['genetics'];
 $age = $hireco_package['age'];
 $birthdate = $hireco_package['birthdate'];
 $gender = $hireco_package['gender'];
 $bodypart_id = $hireco_package['bodypart_id'];
 $origin = $hireco_package['origin'];
 $sub_origin = $hireco_package['sub_origin'];
 $target = $hireco_package['target'];
 $sub_target = $hireco_package['sub_target'];
 $stimuli = $hireco_package['stimuli'];
 $stimuli_strength = $hireco_package['stimuli_strength'];
 $brain_pack = $hireco_package['brain'];
 $body_pack = $hireco_package['body'];

 switch ($age){

  case 1:

   /* Cleavage

   The First Cell Division

   The Zygote stays as a single cell for the first 12 hours since conception

   The final steps in zygote formation include replication of the male and female DNA and the alignment of chromosomes in preparation for the first cell division through mitosis (mi-to’sis).

   The chromosomes assume a formation called a cleavage spindle, which is a phase of mitosis.

   As the 2 sets of chromosomes migrate to opposite ends of the zygote, a crease begins to form along the equator marking the impending line of division.

   The zygote or single-cell embryo completes the first cell division approximately 24 to 30 hours after fertilization.

   The process of repeated cell division is called cleavage.

   */

   $body_package['body_components'][] = ['chromosomes'];
   $body_package['body_component_count'] = 1;
   $body_package['bodypart_cell_count'] = 1;
   $body_package['body_cell_count'] = $body_cell_count + $hireco_package['bodypart_cell_count'];

   $embryo_package = $this->embryo ($embryo_params);
   $hireco_package['embryo'] = $embryo_package;

   $brain_package = $this->brain ($brain_params);
   $body_package = $this->body ($body_params);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

   $hireco_package['bodypart_cell_count'] = 1;
   $hireco_package['body_cell_count'] = $body_cell_count + $hireco_package['bodypart_cell_count'];

  break;
  case 2:

   # Post-Conception
   # Embryogenesis is the process by which the embryo forms and develops.

   /*

   https://en.wikipedia.org/wiki/Prenatal_development

   Week 1

   Gestational age: 2 weeks and 0 days until 2 weeks and 6 days old. 15-21 days from last menstruation.
   Embryonic age: Week nr 1. 0 (whole) weeks old. 1-7 days from fertilization.

   Fertilization of the ovum to form a new human organism, the human zygote. (day 1 of fertilization)
   The zygote undergoes mitotic cellular divisions, but does not increase in size. This mitosis is also known as cleavage. A hollow cavity forms marking the blastocyst stage. (day 1.5?3 of fert.)
   The blastocyst contains only a thin rim of trophoblast cells and a clump of cells at one end known as the "embryonic pole" which include embryonic stem cells.
   The embryo hatches from its protein shell (zona pellucida) and performs implantation onto the endometrial lining of the mother's uterus. (day 5?6 of fert.)
   If separation into identical twins occurs, 1/3 of the time it will happen before day 5.

   */

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 
  case 3:

  break; 
  case 4:

  break; 
  case 5:

   /*

   */

  break; 
  case 6:

  break;
  case 7:

  break; 

 } # end age switch 

 return $hireco_package;

} # Zygote

# Zygote
##################################
# Embryo

function embryo ($hireco_package){

 switch ($age){

  case ($age > 7 && $age <= 14):

   /*

   Ectoderm
   Neural Plate
   Neural Tube

   organogenesis

   Week 2

   Gestational age: 3 weeks and 0 days until 3 weeks and 6 days old. 22-28 days from last menstruation.

   Embryonic age: Week nr 2. 1 week old. 8-14 days from fertilization.

   Trophoblast cells surrounding the embryonic cells proliferate and invade deeper into the uterine lining. They will eventually form the placenta and embryonic membranes. The blastocyst is fully implanted day 7-12 of fert.
   Formation of the yolk sac.
   The embryonic cells flatten into a disk, two cells thick.
   If separation into identical twins occurs, 2/3 of the time it will happen between days 5 and 9. If it happens after day 9, there is a significant risk of the twins being conjoined.
   Primitive streak develops. (day 13 of fert).
   Primary stem villi appear. (day 13 of fert).

   */

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 
  case ($age > 14 && $age <= 21):

   /*

   Week 3

   Gestational age: 4 weeks and 0 days until 4 weeks and 6 days old. 29-35 days from last menstruation.

   Embryonic age: Week nr 3. 2 weeks old. 15-21 days from fertilization.

   A notochord forms in the center of the embryonic disk. (day 16 of fert.)
   Gastrulation commences. (day 16 of fert.)
   A neural groove (future spinal cord) forms over the notochord with a brain bulge at one end. Neuromeres appear. (day 18 of fert.)
   Somites, the divisions of the future vertebra, form. (day 20 of fert.)
   Primitive heart tube is forming. Vasculature begins to develop in embryonic disc. (day 20 of fert.)

   */

  break; 
  case ($age > 21 && $age <= 28):

   /*

   Week 4

   Gestational age: 5 weeks and 0 days until 5 weeks and 6 days old. 36-42 days from last menstruation.

   Embryonic age: Week nr 4. 3 weeks old. 22-28 days from fertilization.

   The embryo measures 4 mm (1/8 inch) in length and begins to curve into a C shape.
   The heart bulges, further develops, and begins to beat in a regular rhythm. Septum primum appears.
   Pharyngeal arches, grooves which will form structures of the face and neck, form.
   The neural tube closes.
   The ears begin to form as otic pits.
   Arm buds and a tail are visible.
   Lung bud, the first traits of the lung appear.
   Hepatic plate, the first traits of the liver appear.
   Buccopharyngeal membrane ruptures. This is the future mouth.
   Cystic diverticulum, which will become the gallbladder, and dorsal pancreatic bud, which will become the pancreas appear.
   Urorectal septum begins to form. Thus, the rectal and urinary passageways become separated.
   Anterior and posterior horns differentiate in the spinal cord.
   Spleen appears.
   Ureteric buds appear.

   */
  

  break;
  case ($age > 28 && $age <= 35):

   /*

   Week 5

   Gestational age: 6 weeks and 0 days until 6 weeks and 6 days old. 43-49 days from last menstruation.

   Embryonic age: Week nr 5. 4 weeks old. 29-35 days from fertilization.

   The embryo measures 1.6 cm (5/4 inch) in length and weighs about 1 gram.
   Optic vesicles and optic cups form the start of the developing eye.
   Nasal pits form.
   The brain divides into 5 vesicles, including the early telencephalon.
   Leg buds form and hands form as flat paddles on the arms.
   Rudimentary blood moves through primitive vessels connecting to the yolk sac and chorionic membranes.
   The metanephros, precursor of the definitive kidney, starts to develop.
   The initial stomach differentiation begins.

   */
  
  break;
  case ($age > 35 && $age <= 42):

   /*

   Week 6

   Gestational age: 7 weeks and 0 days until 7 weeks and 6 days old. 50?56 days from last menstruation.

   Embryonic age: Week nr 6. 5 weeks old. 36?42 days from fertilization.

   The embryo measures 13 mm (1/2 inch) in length.
   Lungs begin to form.
   The brain continues to develop.
   Arms and legs have lengthened with foot and hand areas distinguishable.
   The hands and feet have digits, but may still be webbed.
   The gonadal ridge begins to be perceptible.
   The lymphatic system begins to develop.
   Main development of sex organs starts.

   */
  
  break;
  case ($age > 42 && $age <= 49):

   /*

   Week 7

   Gestational age: 8 weeks and 0 days until 8 weeks and 6 days old. 57?63 days from last menstruation.

   Embryonic age: Week nr 7. 6 weeks old. 43?49 days from fertilization.

   The embryo measures 18 mm (3/4 inch) in length.
   Fetal heart tone (the sound of the heart beat) can be heard using doppler.
   Heart beats twice as fast as mother's
   Nipples and hair follicles begin to form.
   Location of the elbows and toes are visible.
   Spontaneous limb movements may be detected by ultrasound.
   All essential organs have at least begun.
   The vitelline duct normally closes.

   */

  break;

 } # end age switch 

 return $hireco_package;

} # Embryo

# Embryo
##################################
# Foetus

function foetus ($hireco_package){

 switch ($age){

  case ($age > 49 && $age <= 63):

   /*

   Weeks 8-10

   Gestational age: 9 weeks and 0 days until 11 weeks and 6 days old.

   Embryonic age: Weeks nr 8?10. 7?9 weeks old.

   All major structures are already formed in the fetus, but they continue to grow and develop.
   Since the precursors of all the major organs are created by this time, the fetal period is described both by organ and by a list of changes by weeks of gestational age.

   Embryo measures 30?80 mm (1.2?3.2 inches) in length.
   Ventral and dorsal pancreatic buds fuse during the 8th week
   Intestines rotate.
   Facial features continue to develop.
   The eyelids are more developed.
   The external features of the ear begin to take their final shape.
   The head comprises nearly half of the fetus' size.
   The face is well formed.
   The eyelids close and will not reopen until about the 28th week.
   Tooth buds, which will form the baby teeth, appear.
   The limbs are long and thin.
   The fetus can make a fist with its fingers.
   Genitals appear well differentiated.
   Red blood cells are produced in the liver.
   Heartbeat can be detected by ultrasound.

   */

  break;
  case ($age > 63 && $age <= 56):

   /*

   Week 11-14

   Gestational age: 12 weeks and 0 days until 15 weeks and 6 days old.

   Embryonic age: Weeks nr 11?14. 10?13 weeks old.

   The fetus reaches a length of about 15 cm (6 inches).
   A fine hair called lanugo develops on the head.
   Fetal skin is almost transparent.
   More muscle tissue and bones have developed, and the bones become harder.
   The fetus makes active movements.
   Sucking motions are made with the mouth.
   Meconium is made in the intestinal tract.
   The liver and pancreas produce fluid secretions.
   From week 13, sex prediction by obstetric ultrasonography is almost 100% accurate.
   At week 15, main development of external genitalia is finished.

   */

  break;

 } # end age switch 

 return $foetus_package;

} # Foetus

# Foetus
##################################
# Birth

function birth ($hireco_package){

 switch ($age){

  case ($age == 252):

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 

 } # end age switch 

 return $hireco_package;

} # Birth

# Birth
##################################
# Infant

function infant ($hireco_package){

 switch ($age){

  case ($age > 252 && $age < 616):

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 

 } # end age switch 

 return $hireco_package;

} # Infant

# Infant
##################################
# Child

function child ($hireco_package){

 switch ($age){

  case ($age > 616 && $age <= 980):

   # 1-2 years

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 

 } # end age switch 

 return $hireco_package;

} # Child

# Child
##################################
# Teen

function teen ($hireco_package){

 switch ($age){

  case ($age > 43444 && $age <= 443434):

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 

 } # end age switch 

 return $hireco_package;

} # Teen

# Teen
##################################
# Adult

function adult ($hireco_package){

 $event_id = $hireco_package['event_id'];
 $profile_id = $hireco_package['profile_id'];
 $datetime  = $hireco_package['datetime'];
 $mother = $hireco_package['mother'];
 $genetics = $hireco_package['genetics'];
 $age = $hireco_package['age'];
 $birthdate = $hireco_package['birthdate'];
 $gender = $hireco_package['gender'];
 $bodypart_id = $hireco_package['bodypart_id'];
 $origin = $hireco_package['origin'];
 $sub_origin = $hireco_package['sub_origin'];
 $target = $hireco_package['target'];
 $sub_target = $hireco_package['sub_target'];
 $stimuli = $hireco_package['stimuli'];
 $stimuli_strength = $hireco_package['stimuli_strength'];
 $brain_pack = $hireco_package['brain'];
 $body_pack = $hireco_package['body'];

 switch ($age){

  case ($age > 149 && $age <= 14602): # 40

   #

  break; 
  case ($age > 14602 && $age <= 16065): # 44

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 
  case ($age > 16065 && $age <= 16422): # 45

   $brain_package = $this->brain ($hireco_package);
   $body_package = $this->body ($hireco_package);

   $hireco_package['brain'] = $brain_package;
   $hireco_package['body'] = $body_package;

  break; 

 } # end age switch 

 return $hireco_package;

} # Adult

# Adult
##################################
# Brain
# https://en.wikipedia.org/wiki/Development_of_the_human_brain
# https://en.wikipedia.org/wiki/List_of_regions_in_the_human_brain
# The human brain is composed of neurons, glial cells, and blood vessels.
# The number of neurons is estimated at roughly 100 billion.
# Electrically excitable cell that processes and transmits information through electrical and chemical signals
# Signals between neurons occur via synapses
# Neurons can connect to each other to form neural networks

function brain ($params){

 $event_id = $params['event_id'];
 $profile_id = $params['profile_id'];
 $age = $params['age'];
 $origin = $params['origin'];
 $sub_origin = $params['sub_origin'];
 $target = $params['target'];
 $sub_target = $params['sub_target'];
 $stimuli = $params['stimuli'];
 $stimuli_strength = $params['stimuli_strength'];

 # Brain Genetics
 # Brain Pattern Count Propensity: 0-100 %
 # Used together with surregate data to build virtual data
 # Neurons connected to other neurons represents a pattern
 # Pattern Count = the number of neurons connected to other neurons
 # Patterns are collections of values of various types 

 /*

 Genetics need to somehow be used to affect the data

 $genetic_predi_brain_pattern_count = $data['genetic_predisposition_brain_pattern_count'];
 if (!$genetic_predi_brain_pattern_count){
    $genetic_predi_brain_pattern_count = 0.1;
    }

 # Brain
 $brain_pattern_count = $data['brain_pattern_count']; # Brain Activity Pattern Count
 # Measure the total number of patterns stored

 $brain_pattern_count_male = $data['brain_pattern_count_male']; # Aggregate Surregate Male Data
 $brain_pattern_count_female = $data['brain_pattern_count_female']; # Aggregate Surregate Female Data

 if (!$brain_pattern_count){
    if ($gender == "male"){
       if (!$brain_pattern_count_male){
          $brain_pattern_count = 0;
          } else {
          $brain_pattern_count = $brain_pattern_count_male;
          } 
       } else {
       if (!$brain_pattern_count_female){
          $brain_pattern_count = 0;
          } else {
          $brain_pattern_count = $brain_pattern_count_female;
          } 
       }
    }

 $brain_pattern_count = $brain_pattern_count * $genetic_predi_brain_pattern_count;

 # The frequency with which particular patterns are being called
 # Min:1 - a pattern exists, thus it has had at least one frequency

 $brain_patterns = $data['brain_patterns'];

 
 $brain_pattern_frequency = $data['brain_pattern_frequency'];
 if (!$brain_pattern_frequency){
    $brain_pattern_frequency = 1;
    }

 if (is_array($data)){

    for ($data_cnt=0;$data_cnt < count($data);$data_cnt++){

        $data_type = $data[$data_cnt]['data_type'];
        $data_value = $data[$data_cnt]['data_value'];


        } # for  

    } # is array

 */

 # On the surface of the brain is an area known as the somato-sensory cortex. It is the brain’s map of the body, known familiarly as the “homunculus.”
 # http://alinenewton.com/neuroscience-of-touch-touch-and-the-brain/

 $touch_areas = array ('Organs','Pharynx','Tongue','Teeth','Gums','Jaw','Lower Lip','Lips','Upper lip','Face','Nose','Eye','Thumb','Finger-Index','Finger-Middle','Finger-Ring','Finger-Little','Hand','Wrist','Forearm','Elbow','Arm','Shoulder','Head','Neck','Trunk','Hip','Leg','Foot','Toes','Genetalia');

 # Age reflects the capacity for the brain to manage data

 if ($age > 100){

    # Must change this for when the brain and body are developed

    # Regardless of location, if the type of touch is dangerous, we must trigger the pain or fear instinct with increasing intensity based on strength as continued until subdued

    switch ($origin){

     case 'trunk':

      # Stimuli journey mapping from the trunk

      $stimuli_relations[$event_id][1]['origin'] = $origin;
      $stimuli_relations[$event_id][1]['sub_origin'] = $sub_origin;
      $stimuli_relations[$event_id][1]['stimuli'] = $stimuli;
      $stimuli_relations[$event_id][1]['stimuli_strength'] = $stimuli_strength;

      $stimuli_relations[$event_id][2]['origin'] = $sub_origin;
      $stimuli_relations[$event_id][2]['sub_origin'] = "nerves";
      $stimuli_relations[$event_id][2]['stimuli'] = $stimuli;
      $stimuli_relations[$event_id][2]['stimuli_strength'] = $stimuli_strength;

      $stimuli_relations[$event_id][3]['origin'] = "nerves";
      $stimuli_relations[$event_id][3]['sub_origin'] = "spinal_cord";
      $stimuli_relations[$event_id][3]['stimuli'] = $stimuli;
      $stimuli_relations[$event_id][3]['stimuli_strength'] = $stimuli_strength;

      $stimuli_relations[$event_id][4]['origin'] = "spinal_cord";
      $stimuli_relations[$event_id][4]['sub_origin'] = "medulla";
      $stimuli_relations[$event_id][4]['stimuli'] = $stimuli;
      $stimuli_relations[$event_id][4]['stimuli_strength'] = $stimuli_strength;

      $stimuli_relations[$event_id][5]['origin'] = "medulla";
      $stimuli_relations[$event_id][5]['sub_origin'] = "homunculus";
      $stimuli_relations[$event_id][5]['stimuli'] = $stimuli;
      $stimuli_relations[$event_id][5]['stimuli_strength'] = $stimuli_strength;

      $stimuli_relations[$event_id][6]['origin'] = "homunculus";
      $stimuli_relations[$event_id][6]['sub_origin'] = "primary_motor_cortex";
      $stimuli_relations[$event_id][6]['stimuli'] = $stimuli;
      $stimuli_relations[$event_id][6]['stimuli_strength'] = $stimuli_strength;

      $stimuli_relations[$event_id][7]['origin'] = "homunculus";
      $stimuli_relations[$event_id][7]['sub_origin'] = "supplementary_motor_cortex";
      $stimuli_relations[$event_id][7]['stimuli'] = $stimuli;
      $stimuli_relations[$event_id][7]['stimuli_strength'] = $stimuli_strength;


      /*

      Originally created with Json code, but is already converted upon return to hireco function

      $stimuli_relations .= '{"origin":"'.$origin.'","sub_origin":"'.$sub_origin.'","stimuli":"'.$stimuli.'","stimuli_strength":"'.$stimuli_strength.'}';

      $stimuli_relations .= '{"origin":"'.$sub_origin.'","sub_origin":"nerves","stimuli":"'.$stimuli.'","stimuli_strength":"'.$stimuli_strength.'}';

      $stimuli_relations .= '{"origin":"nerves","sub_origin":"spinal_cord","stimuli":"'.$stimuli.'","stimuli_strength":"'.$stimuli_strength.'}';

      $stimuli_relations .= '{"origin":"spinal_cord","sub_origin":"medulla","stimuli":"'.$stimuli.'","stimuli_strength":"'.$stimuli_strength.'}';

      $stimuli_relations .= '{"origin":"medulla","sub_origin":"homunculus","stimuli":"'.$stimuli.'","stimuli_strength":"'.$stimuli_strength.'}';

      $stimuli_relations .= '{"origin":"homunculus","sub_origin":"primary_motor_cortex","stimuli":"'.$stimuli.'","stimuli_strength":"'.$stimuli_strength.'}';

      $stimuli_relations .= '{"origin":"homunculus","sub_origin":"supplementary_motor_cortex","stimuli":"'.$stimuli.'","stimuli_strength":"'.$stimuli_strength.'}';

      */

      # Further relationships should include data on WHO did the touching

     break;
     case 'Finger-Index':

     break;

    } # Switch

   } # If age

 # Touch and Emotion - Touch has been shown to have a positive emotional impact. In one study a group of women were told they were to receive a shock. The effect of hand-holding by their husbands and by a technician was measured. In both cases, the effect of the touch was to lessen the threat response that registers in the limbic system, the parts of the brain associated with emotion. 


 if ($age > 23 && $origin == 'brain' && $sub_origin == 'hypothalamus'){

    /* 

    Functions that will take place continuously while alive - ANS = Autonomic Nervous System
    Will be instantiated by the auto cron only

    The hypothalamus is responsible for certain metabolic processes and other activities of the autonomic nervous system. 
    ANS = Autonomic Nervous System
    Regulates bodily functions such as the heart rate, digestion, respiratory rate, pupillary response, urination, and sexual arousal. 
    The primary mechanism in control of the fight-or-flight response and the freeze-and-dissociate response

    Adrenilin pumping into the blood could be caused by a sudden event based on fear caused by mental determinations based on past experiences, etc. Still the brain, but respiration may ramp up..

    This event will be linked to that physical event of seeing or hearing..

    */

    switch ($target){

     case 'brain':

     break;
     case 'body':

      switch ($sub_target){

       case 'heart':
    
        /*

        Digestion relates to heart & circulation - every second

        Heart rate is the speed of the heartbeat measured by the number of contractions of the heart per minute (bpm). The heart rate can vary according to the body's physical needs, including the need to absorb oxygen and excrete carbon dioxide. It is usually equal or close to the pulse measured at any peripheral point. Activities that can provoke change include physical exercise, sleep, anxiety, stress, illness, and ingestion of drugs.

        */

        $stimuli_relations[$event_id][]['origin'] = "brain";
        $stimuli_relations[$event_id][]['sub_origin'] = "hypothalamus";
        $stimuli_relations[$event_id][]['target'] = "body";
        $stimuli_relations[$event_id][]['sub_target'] = "heart";
        $stimuli_relations[$event_id][]['stimuli'] = "contraction";
        $stimuli_relations[$event_id][]['stimuli_strength'] = $stimuli_strength;
        $stimuli_relations[$event_id][]['regular_count'] = 0;
        $stimuli_relations[$event_id][]['irregular_count'] = 0;
        $stimuli_relations[$event_id][]['severity_count'] = 0;
        $stimuli_relations[$event_id][]['severity_level'] = 0;

       break;
       case 'digestion':

        # Digestion relates to digestive tract
        $stimuli_relations[$event_id][]['origin'] = "brain";
        $stimuli_relations[$event_id][]['sub_origin'] = "hypothalamus";
        $stimuli_relations[$event_id][]['target'] = "body";
        $stimuli_relations[$event_id][]['sub_target'] = "digestion";
        $stimuli_relations[$event_id][]['stimuli'] = "contraction";
        $stimuli_relations[$event_id][]['stimuli_strength'] = $stimuli_strength;
        $stimuli_relations[$event_id][]['regular_count'] = 0;
        $stimuli_relations[$event_id][]['irregular_count'] = 0;
        $stimuli_relations[$event_id][]['severity_count'] = 0;
        $stimuli_relations[$event_id][]['severity_level'] = 0;

       break;
       case 'respiratory':

        # Digestion relates to digestive tract
        $stimuli_relations[$event_id][]['origin'] = "brain";
        $stimuli_relations[$event_id][]['sub_origin'] = "hypothalamus";
        $stimuli_relations[$event_id][]['target'] = "body";
        $stimuli_relations[$event_id][]['sub_target'] = "respiratory";
        $stimuli_relations[$event_id][]['stimuli'] = "contraction";
        $stimuli_relations[$event_id][]['stimuli_strength'] = $stimuli_strength;
        $stimuli_relations[$event_id][]['regular_count'] = 0;
        $stimuli_relations[$event_id][]['irregular_count'] = 0;
        $stimuli_relations[$event_id][]['severity_count'] = 0;
        $stimuli_relations[$event_id][]['severity_level'] = 0;

       break;

      } # end switch for subtarget within body

     break; # end body switch

    } # end switch for target

    } # end if for brain/hypothalamus

 $brain_pack['stimuli_relations'] = $stimuli_relations;

 switch ($age){

  # The span between each age range will increase over time as changes will slow down

  case ($age < 23):

    # The brain has yet to be formed

    $brain_pack['brain_neurons'] = 0;
    $brain_pack['brain_axons'] = 0;
    $brain_pattern_count = 0;

    $body_params['origin'] = 'brain';
    $body_params['sub_origin'] = 'hypothalamus';
    $body_params['target'] = 'body';
    $body_params['sub_target'] = "heart";

    $body_patterns .= $this->body ($params);

  break;
  case ($age > 23 && $age < 32):

   # Ectoderm
   # Neural Plate
   # Neural Tube

  break; 
  case ($age > 32 && $age < 49):
  
   # Up to 33 Days - posterior (epithalamic) commissure appears
      # Up to 33 Days - medial forebrain bundle appears

  break;
  case ($age > 49 && $age < 99):

   #

  break;
  case ($age > 99 && $age < 149):

   #

  break; 
  case ($age > 149 && $age < 14602): # 40

   #

  break; 
  case ($age >= 14602 && $age <= 16065): # 44

   # Create some kind of pattern


  break; 
  case ($age >= 16065 && $age <= 16422): # 45

   #

    $brain_pack['brain_neurons'] = 0;
    $brain_pack['brain_axons'] = 0;
    $brain_pattern_count = 0;


  break; 

  } # end switch

 return $brain_pack;

} # End core brain function

function rhombencephalon ($params){

 # Hindbrain (rhombencephalon) - portions of the central nervous system in vertebrates that includes the medulla, pons, and cerebellum. Together they support vital bodily processes vital bodily processes

} # end rhombencephalon function

function mesencephalon ($params){

 # Midbrain (mesencephalon) - portion of the central nervous system associated with vision, hearing, motor control, sleep/wake, arousal (alertness), and temperature regulation.

} # end mesencephalon function

function prosencephalon ($params){

 # Forebrain (prosencephalon) -  It controls body temperature, reproductive functions, eating, sleeping, and any display of emotions.

} # end prosencephalon function

# End Brain parts
##################################
# Body

function body ($params){

 # Receives all body data from external and brain
 # Brain = messages
 # External = stimuli (pressure, temperature, gravity, etc)

 $event_id = $params['event_id'];
 $profile_id = $params['profile_id'];
 $age = $params['age'];
 $origin = $params['origin'];
 $sub_origin = $params['sub_origin'];
 $target = $params['target'];
 $sub_target = $params['sub_target'];
 $stimuli = $params['stimuli'];
 $stimuli_strength = $params['stimuli_strength'];

 $body_event = $this->stimulus ($stimuli);

 # Get general body data
 # These figures may be changed based on the resulting event that follows - such as eating..

 $body_size = $data['body_size']; # Body Size
 $body_params['body_size'] = $body_size;
  #-> Consider all body parts dimensions

 $body_speed = $data['body_speed']; # Body Activity Speed
 $body_params['body_speed'] = $body_speed;
  #-> Consider all body parts speed

 $body_coordination_accuracy = $data['body_coordination_accuracy']; # Body Coordination Accuracy
 $body_params['body_coordination_accuracy'] = $body_coordination_accuracy;
  #-> Consider all body parts coordination
      #-> Hand-to-hand
      #-> Foot-to-foot
      #-> Hand-to-foot
      #-> Eye-to-hand

 $body_balance_accuracy = $data['body_balance_accuracy']; # Body Balance Accuracy
 $body_params['body_balance_accuracy'] = $body_balance_accuracy;

 $body_strength = $data['body_strength']; # Body Strength
 $body_params['body_strength'] = $body_strength;
  #-> Consider all body parts strength based on muscle/joint groups
      #-> Hand grip
      #-> Bicep lift
      #-> Leg Squat
 $body_posture = $data['body_posture']; # Body Posture
 $body_params['body_posture'] = $body_posture;

 # Age reflects the capacity for the brain to manage data
 
 switch ($target){

  case 'brain':

   # Some external stimuli sent to the brain for processing will return from the brain for action

   switch ($sub_target){

    case 'hypothalamus':

     # 

    break;

   } # switch sub_origin

  break;
  case 'body':

   # Some external stimuli need to be sent to the brain for processing

   switch ($sub_target){

    case 'heart':

     /*

     The Circulatory Systems main organ is the heart and the purpose of our heart is so that we can stay alive. The other parts that helps make up this organ are arteries, veins, chambers, valves and vessels. There are 4 chambers: The Right & Left Atrium and The Right & Left Ventricle. The right side of your heart receives oxygen poor blood from the body to the lungs to get rid of carbon dioxide. The left side is oxygen rich which receives blood from the lungs to send back into the body. There are 4 valves: Pulmonary valve, Aortic valve, Tricuspid valve, and Mitral valve. The beating of your heart is the sound of these valves opening and closing. When you take your blood pressure it is the measurement of the force of blood as it goes through your arteries. This system also works with the Respiratory System. A disease of the heart could be a heart attack. 
     */

    break; # Heart
    case 'fingers':

     # 

    break; #Fingers

   } # switch sub_origin

  break;

 } # end origin switch

 return $body_params;

} # end body function

function legs ($params){


} # end function legs

function stimulus ($params){

 $stimuli = $params['stimuli'];

 switch ($stimuli){

  case 'touch':

   #
   $stimuli_pack['pain'] = 0;
   $stimuli_pack['pain_level'] = 0;
   $stimuli_pack['eronous_level'] = 5;
   $stimuli_pack['wake_potential'] = 2;
   $stimuli_pack['annoyance_potential'] = 2;

  break;
  case 'wipe':

  break;
  case 'flick':

  break;
  case 'rub':

  break;
  case 'pressure':

  break;
  case 'heat':

  break;
  case 'cool':

  break;
  case 'burn':

  break;
  case 'freeze':

  break;
  case 'cut':

  break;
  case 'graze':

  break;

 } # end switch

 return $stimuli_pack;

} # end sensory

# End Body Parts
##################################
# Actions, Stimuli, chemicals, hormones

function stimulus_types (){

 $stimulus_types_pack[0]['id'] = 'touch';
 $stimulus_types_pack[0]['name'] = 'Touch';
 $stimulus_types_pack[1]['id'] = 'wipe';
 $stimulus_types_pack[1]['name'] = 'Wipe';
 $stimulus_types_pack[2]['id'] = 'flick';
 $stimulus_types_pack[2]['name'] = 'Flick';
 $stimulus_types_pack[3]['id'] = 'rub';
 $stimulus_types_pack[3]['name'] = 'Rub';
 $stimulus_types_pack[4]['id'] = 'pressure';
 $stimulus_types_pack[4]['name'] = 'Pressure';
 $stimulus_types_pack[5]['id'] = 'heat';
 $stimulus_types_pack[5]['name'] = 'Heat';
 $stimulus_types_pack[6]['id'] = 'cool';
 $stimulus_types_pack[6]['name'] = 'Cool';
 $stimulus_types_pack[7]['id'] = 'burn';
 $stimulus_types_pack[7]['name'] = 'Burn';
 $stimulus_types_pack[8]['id'] = 'freeze';
 $stimulus_types_pack[8]['name'] = 'Freeze';
 $stimulus_types_pack[9]['id'] = 'cut';
 $stimulus_types_pack[9]['name'] = 'Cut';
 $stimulus_types_pack[10]['id'] = 'graze';
 $stimulus_types_pack[10]['name'] = 'Graze';

 return $stimulus_types_pack;

} # end stimulus types

# End Actions, Stimuli, chemicals, hormones
######################################################
# Record Events

function event_recorder ($params){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  $record_location = $params[0];
  $record_name = $params[1];
  $record_content = $params[2];

  $record_file = $record_location."/".$record_name;

  $record_date = date ("Y-m-d G:i:s");

  ##############################
  # Check record size

  $size = filesize($record_file);

  if ($size>500000){

     $archdate = str_replace(" ", "_", $record_date);
     $archdate = str_replace(":", "-", $archdate);
     $archive = $record_location."/".$record_name."_".$archdate.".archive";
     copy($record_file, $archive);
     unlink($record_file);

     }

  #
  ##############################

  $record = $record_content."\n";
  $fh = fopen ($record_file, 'w');
  #$fh = fopen ($record_file, 'a');
  fwrite ($fh, $record);
  fclose ($fh);

  }

# End Event Recorder
#################################

} # end class

?>