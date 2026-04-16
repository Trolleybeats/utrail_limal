<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    participant: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    date_naissance: '',
    participation_un: '',
    distance_un: '',
    logement_un: '',
    participation_deux: '',
    distance_deux: '',
    logement_deux: '',
    tshirt_taille: '',
    rgpd: false,
    inscription: false,
});

const submit = () => {
    form.post(`/paiement/${props.participant.token}`, {
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            alert(
                "Une erreur est survenue lors de l'envoi de votre inscription. Veuillez réessayer.",
            );
        },
    });
};
</script>

<template>
    <!-- Hero header -->
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/paiement.jpg"
                alt="Paiement U-Trail Limal"
                class="h-full w-full object-cover object-[center_60%]"
            />
        </figure>
    </header>
    <main>
        <section class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Inscription au projet
            </h2>
        </section>
        <form
            @submit.prevent="submit"
            class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14"
        >
            <!-- Participant info -->
            <div class="mb-8 rounded-[6px] bg-white px-6 py-4">
                <p
                    class="text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Inscription pour :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ participant.prenom }} {{ participant.nom }}
                    </span>
                </p>
                <p class="mt-1 text-[15px] text-[#586166]">
                    {{ participant.email }}
                </p>
            </div>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="date_naissance"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Date de naissance&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <input
                    v-model="form.date_naissance"
                    type="date"
                    id="date_naissance"
                    name="date_naissance"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                />
                <p
                    v-if="form.errors.date_naissance"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.date_naissance }}
                </p>
            </div>

            <!-- Course n°1 -->
            <h3 class="mb-4 text-xl font-semibold md:mb-6 md:text-[36px]">
                Course n°1
            </h3>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="participation_un"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Participation (si vous ne participez pas, cliquez sur non
                    aux autres questions de la course n°1) &nbsp;<span
                        class="text-[#c42827]"
                        >*</span
                    >
                </label>
                <select
                    v-model="form.participation_un"
                    id="participation_un"
                    name="participation_un"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option :value="1">Oui</option>
                    <option :value="0">Non</option>
                </select>
                <p
                    v-if="form.errors.participation_un"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.participation_un }}
                </p>
            </div>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="distance_un"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Distance&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <select
                    v-model="form.distance_un"
                    id="distance_un"
                    name="distance_un"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option value="trente">30 km</option>
                    <option value="cinquante">50 km</option>
                    <option value="septante">70 km</option>
                    <option value="ultra-marathon">100 km</option>
                    <option value="ultra-trail">100 miles</option>
                    <option value="non">Non</option>
                </select>
                <p
                    v-if="form.errors.distance_un"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.distance_un }}
                </p>
            </div>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="logement_un"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Logement&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <select
                    v-model="form.logement_un"
                    id="logement_un"
                    name="logement_un"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option :value="1">Oui</option>
                    <option :value="0">Non</option>
                </select>
                <p
                    v-if="form.errors.logement_un"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.logement_un }}
                </p>
            </div>

            <!-- Course n°2 -->
            <h3 class="mb-4 text-xl font-semibold md:mb-6 md:text-[36px]">
                Course n°2
            </h3>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="participation_deux"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Participation (si vous ne participez pas, cliquez sur non
                    aux autres questions de la course n°2) &nbsp;<span
                        class="text-[#c42827]"
                        >*</span
                    >
                </label>
                <select
                    v-model="form.participation_deux"
                    id="participation_deux"
                    name="participation_deux"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option :value="1">Oui</option>
                    <option :value="0">Non</option>
                </select>
                <p
                    v-if="form.errors.participation_deux"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.participation_deux }}
                </p>
            </div>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="distance_deux"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Distance&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <select
                    v-model="form.distance_deux"
                    id="distance_deux"
                    name="distance_deux"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option value="trente">30 km</option>
                    <option value="cinquante">50 km</option>
                    <option value="septante">70 km</option>
                    <option value="ultra-marathon">100 km</option>
                    <option value="ultra-trail">100 miles</option>
                    <option value="non">Non</option>
                </select>
                <p
                    v-if="form.errors.distance_deux"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.distance_deux }}
                </p>
            </div>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="logement_deux"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Logement&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <select
                    v-model="form.logement_deux"
                    id="logement_deux"
                    name="logement_deux"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option :value="1">Oui</option>
                    <option :value="0">Non</option>
                </select>
                <p
                    v-if="form.errors.logement_deux"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.logement_deux }}
                </p>
            </div>

            <!-- T-shirt -->
            <h3 class="mb-4 text-xl font-semibold md:mb-6 md:text-[36px]">
                T-shirt
            </h3>
            <div class="mb-6 flex flex-col gap-4">
                <label
                    for="tshirt_taille"
                    class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Taille&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <select
                    v-model="form.tshirt_taille"
                    id="tshirt_taille"
                    name="tshirt_taille"
                    required
                    class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
                >
                    <option value="" disabled>Choisissez une option</option>
                    <option value="xs">XS</option>
                    <option value="s">S</option>
                    <option value="m">M</option>
                    <option value="l">L</option>
                    <option value="xl">XL</option>
                    <option value="xxl">XXL</option>
                </select>
                <p
                    v-if="form.errors.tshirt_taille"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.tshirt_taille }}
                </p>
            </div>

            <!-- RGPD -->
            <div class="mb-6 flex items-start gap-2">
                <input
                    v-model="form.rgpd"
                    type="checkbox"
                    id="rgpd"
                    name="rgpd"
                    required
                    class="mt-1 h-[25px] w-[25px] shrink-0 accent-[#c42827]"
                />
                <label
                    for="rgpd"
                    class="text-[16px] leading-[22px] text-black md:text-[18px]"
                >
                    En cochant cette case, j'accepte que mes données
                    personnelles renseignées lors de cette inscription soient
                    transmises à U-trail Limal pour la gestion de ma
                    participation. J'ai lu et j'accepte la politique de
                    confidentialité.&nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <p v-if="form.errors.rgpd" class="text-sm text-[#c42827]">
                    {{ form.errors.rgpd }}
                </p>
            </div>

            <!-- Inscription -->
            <div class="mb-6 flex items-start gap-2">
                <input
                    v-model="form.inscription"
                    type="checkbox"
                    id="inscription"
                    name="inscription"
                    required
                    class="mt-1 h-[25px] w-[25px] shrink-0 accent-[#c42827]"
                />
                <label
                    for="inscription"
                    class="text-[16px] leading-[22px] text-black md:text-[18px]"
                >
                    En cochant cette case, je comprends que cette inscription
                    vaut pour inscription définitive au projet. La présente
                    inscription donne accès à l’ensemble du programme
                    d’entrainement ainsi qu’aux courses liées au projet.
                    &nbsp;<span class="text-[#c42827]">*</span>
                </label>
                <p
                    v-if="form.errors.inscription"
                    class="text-sm text-[#c42827]"
                >
                    {{ form.errors.inscription }}
                </p>
            </div>

            <!-- Submit button -->
            <div class="flex justify-center pt-4">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-[2px] bg-[#c42827] px-[44px] py-[18px] text-[20px] leading-[22px] font-semibold text-white hover:bg-[#a82120] focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-[24px]"
                >
                    Payer
                </button>
            </div>
        </form>
    </main>
    <Footer />
</template>
