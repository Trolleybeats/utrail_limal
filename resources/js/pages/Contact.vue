<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { submit as contactSubmit } from '@/routes/contact';

const form = useForm({
    prenom: '',
    nom: '',
    email: '',
    telephone: '',
    message: '',
});

const submitForm = () => {
    form.post(contactSubmit().url, {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>

<template>
    <Head>
        <title>Contact</title>
        <meta
            name="description"
            content="Contactez le club de trail U-Trail Limal. Retrouvez notre adresse à Limal (Brabant wallon), notre email et notre numéro de téléphone pour toute demande."
        />
        <meta
            name="keywords"
            content="contact club trail, adresse Limal, email club, téléphone club, contact U-Trail, club trail Brabant wallon"
        />
        <meta property="og:title" content="Contact" />
        <meta
            property="og:description"
            content="Contactez le club de trail U-Trail Limal. Adresse, email et téléphone disponibles pour toute demande."
        />
        <meta property="og:url" content="https://utrail-limal.be/contact" />
    </Head>
    <!-- Hero header -->
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/contact.jpg"
                alt="Contact U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>

    <!-- Contact form section -->
    <main id="main-content">
        <div class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Contact
            </h2>
        </div>
        <section
            id="contact"
            class="flex flex-col pb-10 md:flex-row md:pb-[50px]"
        >
            <!-- Left: image (hidden on mobile) -->
            <div class="relative hidden flex-shrink-0 md:block md:w-[44%]">
                <img
                    src="/storage/form.jpg"
                    alt="Trail U-Trail Limal"
                    class="absolute h-full w-full object-cover"
                />
                <div class="absolute inset-0 bg-[#d9d9d9] opacity-30"></div>
            </div>

            <!-- Right: form + suivez-nous -->
            <div class="flex flex-1 flex-col">
                <div
                    class="flex-1 px-4 py-8 sm:px-8 sm:py-10 lg:px-14 lg:py-16"
                >
                    <h2
                        class="mb-6 font-title text-2xl leading-tight text-[#1a1a1a] sm:text-3xl md:mb-10 md:text-[40px]"
                    >
                        Une question sur le projet?
                    </h2>

                    <form
                        @submit.prevent="submitForm"
                        class="flex flex-col gap-6 md:gap-8"
                    >
                        <!-- Success message -->
                        <p
                            v-if="form.recentlySuccessful"
                            role="status"
                            aria-live="polite"
                            class="mt-4 text-center text-green-600"
                        >
                            Votre message a été envoyé avec succès !
                        </p>

                        <!-- Prénom + Nom de famille -->
                        <div
                            class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8"
                        >
                            <div class="flex flex-col gap-2">
                                <label
                                    for="prenom"
                                    class="text-base text-[#1a1a1a] md:text-lg lg:text-xl"
                                    >Prénom</label
                                >
                                <input
                                    v-model="form.prenom"
                                    type="text"
                                    id="prenom"
                                    :aria-invalid="!!form.errors.prenom"
                                    :aria-describedby="
                                        form.errors.prenom
                                            ? 'prenom-error'
                                            : undefined
                                    "
                                    :class="[
                                        'border-b-[1.5px] border-black bg-transparent py-2 text-[#1a1a1a] outline-none',
                                        {
                                            'border-red-500':
                                                form.errors.prenom,
                                        },
                                    ]"
                                />
                                <p
                                    v-if="form.errors.prenom"
                                    id="prenom-error"
                                    role="alert"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.prenom }}
                                </p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label
                                    for="nom"
                                    class="text-base text-[#1a1a1a] md:text-lg lg:text-xl"
                                    >Nom de famille</label
                                >
                                <input
                                    v-model="form.nom"
                                    type="text"
                                    id="nom"
                                    :aria-invalid="!!form.errors.nom"
                                    :aria-describedby="
                                        form.errors.nom
                                            ? 'nom-error'
                                            : undefined
                                    "
                                    :class="[
                                        'border-b-[1.5px] border-black bg-transparent py-2 text-[#1a1a1a] outline-none',
                                        { 'border-red-500': form.errors.nom },
                                    ]"
                                />
                                <p
                                    v-if="form.errors.nom"
                                    id="nom-error"
                                    role="alert"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.nom }}
                                </p>
                            </div>
                        </div>

                        <!-- Email + N° de téléphone -->
                        <div
                            class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8"
                        >
                            <div class="flex flex-col gap-2">
                                <label
                                    for="email"
                                    class="text-base text-[#1a1a1a] md:text-lg lg:text-xl"
                                    >Email</label
                                >
                                <input
                                    v-model="form.email"
                                    type="email"
                                    id="email"
                                    :aria-invalid="!!form.errors.email"
                                    :aria-describedby="
                                        form.errors.email
                                            ? 'email-error'
                                            : undefined
                                    "
                                    :class="[
                                        'border-b-[1.5px] border-black bg-transparent py-2 text-[#1a1a1a] outline-none',
                                        { 'border-red-500': form.errors.email },
                                    ]"
                                />
                                <p
                                    v-if="form.errors.email"
                                    id="email-error"
                                    role="alert"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label
                                    for="telephone"
                                    class="text-base text-[#1a1a1a] md:text-lg lg:text-xl"
                                    >N° de téléphone</label
                                >
                                <input
                                    v-model="form.telephone"
                                    type="tel"
                                    id="telephone"
                                    :aria-invalid="!!form.errors.telephone"
                                    :aria-describedby="
                                        form.errors.telephone
                                            ? 'telephone-error'
                                            : undefined
                                    "
                                    :class="[
                                        'border-b-[1.5px] border-black bg-transparent py-2 text-[#1a1a1a] outline-none',
                                        {
                                            'border-red-500':
                                                form.errors.telephone,
                                        },
                                    ]"
                                />
                                <p
                                    v-if="form.errors.telephone"
                                    id="telephone-error"
                                    role="alert"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.telephone }}
                                </p>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="flex flex-col gap-2">
                            <label
                                for="message"
                                class="text-base text-[#1a1a1a] md:text-lg lg:text-xl"
                                >Message</label
                            >
                            <textarea
                                v-model="form.message"
                                rows="3"
                                id="message"
                                :aria-invalid="!!form.errors.message"
                                :aria-describedby="
                                    form.errors.message
                                        ? 'message-error'
                                        : undefined
                                "
                                :class="[
                                    'resize-none border-b-[1.5px] border-black bg-transparent py-2 text-[#1a1a1a] outline-none',
                                    { 'border-red-500': form.errors.message },
                                ]"
                            ></textarea>
                            <p
                                v-if="form.errors.message"
                                id="message-error"
                                role="alert"
                                class="text-sm text-red-500"
                            >
                                {{ form.errors.message }}
                            </p>
                        </div>

                        <!-- Submit -->
                        <div>
                            <button
                                type="submit"
                                @click="submitForm"
                                class="w-full cursor-pointer rounded-sm bg-[#c42827] px-7 py-3 text-base font-semibold text-[#f6f6f6] sm:w-auto sm:text-lg md:text-xl"
                            >
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Suivez-nous strip -->
                <div
                    class="flex min-h-[100px] items-center justify-end gap-3 bg-[#d0c6af] px-4 py-6 sm:min-h-[120px] sm:px-8 md:min-h-[160px] lg:px-14"
                >
                    <span class="text-lg text-[#1a1a1a] sm:text-xl md:text-2xl"
                        ><a href="/MentionLegale" class="hover:underline"
                            >Mentions légales</a
                        ></span
                    >

                    <span>
                        <a
                            href="https://www.facebook.com/profile.php?id=61566596292504"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook U-Trail Limal"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8 sm:h-9 sm:w-9 md:h-[42px] md:w-[42px]"
                                viewBox="0 0 24 24"
                                fill="#1a1a1a"
                            >
                                <path
                                    d="M12 2.04c-5.5 0-10 4.49-10 10.02 0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89 1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02z"
                                />
                            </svg>
                        </a>
                    </span>
                </div>
            </div>
        </section>
    </main>
    <Footer></Footer>
</template>
