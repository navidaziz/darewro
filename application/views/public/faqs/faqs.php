<div class="breadcrumb-div">
	<div class="container">
		<div class="row">
			<div class="col-6">
				<ol class="breadcrumb">
					<li><a href="<?php echo site_url(); ?>"><i style="color:black !important" class="fa fa-home fa-lg"></i> Home</a></li>
				</ol>
			</div>
			<div class="col-6">
				<div class="text-end">
					<h2><?php echo $title; ?></h2>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="div-padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="mb-4">Frequently Asked Questions (FAQs)</h3>
				<div class="accordion" id="faqAccordion">

					<?php
					$faqs = [
						"What is Darewro?" => "Darewro is a fast and reliable home delivery service in Peshawar, offering doorstep delivery of food, groceries, parcels, gifts, books, and even cargo pickups, all with just a call or message.",

						"What types of items can I get delivered through Darewro?" => "We deliver a wide range of items, including:<br>
						• Daily essentials (groceries, toiletries)<br>
						• Food from restaurants and home kitchens<br>
						• Parcels and documents<br>
						• Gifts and cakes<br>
						• Books and stationery<br>
						• Cargo received from terminals<br>
						• Flowers delivery<br>
						• Medicine delivery<br>
						• Clothes from tailor",

						"Do you offer same-day or urgent delivery in Peshawar?" => "Yes! In fact, speed is what we're known for. We offer same-day and even within-the-hour delivery across all areas of Peshawar, depending on availability.",

						"How do I place a delivery request?" => "You can place your order via WhatsApp at <strong>03005799971</strong> or call us at <strong>091 7241724</strong>.",

						"What are your delivery charges?" => "Our delivery charges are based on distance and item type. We offer affordable and transparent pricing, and we’ll always let you know the cost before confirming.",

						"Is Darewro available all over Peshawar?" => "Yes! We cover all areas of Peshawar, including Saddar, Hayatabad, University Town, Cantt, Ring Road, Nasir Bagh Road and more.",

						"Do you offer parcel pickup from cargo terminals in Peshawar?" => "Absolutely! We can receive your parcel from the cargo terminal (Pakistan Railway, Asia Cargo, Dilawar Ada, Faisal Movers, Bilal Travel, Daewoo, Leopard, TCS, M&P etc.) and deliver it safely to your doorstep anywhere in Peshawar.",

						"Can I track my delivery/parcel?" => "Yes, we keep you updated throughout the delivery process via WhatsApp so you always know where your order is.",

						"Are you open on weekends and public holidays?" => "Yes, Darewro operates 7 days a week, including weekends and most public holidays, because we know your needs don’t take a day off!",

						"How can I contact Darewro for support or questions?" => "You can reach us anytime via:<br>
						📞 Phone: <strong>091 7241724</strong><br>
						📱 WhatsApp: <strong>03005799971</strong><br>
						📱 Social Media: <strong>@Darewro</strong>",

						"What is Darewro WhatsApp number?" => "Our WhatsApp number is <strong>03005799971</strong>.",
					];

					$i = 0;
					foreach ($faqs as $question => $answer):
						$collapseId = "faq" . $i;
					?>
						<div class="accordion-item mb-2">
							<h2 class="accordion-header" id="heading<?php echo $i; ?>">
								<button class="accordion-button <?php echo ($i != 0) ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="<?php echo ($i == 0) ? 'true' : 'false'; ?>" aria-controls="<?php echo $collapseId; ?>">
									<?php echo $question; ?>
								</button>
							</h2>
							<div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse <?php echo ($i == 0) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#faqAccordion">
								<div class="accordion-body">
									<?php echo $answer; ?>
								</div>
							</div>
						</div>
					<?php
						$i++;
					endforeach;
					?>

				</div>
			</div>
		</div>
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>