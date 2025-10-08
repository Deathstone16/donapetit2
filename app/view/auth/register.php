<?php
declare(strict_types=1);

/**
 * @var string|null $action
 * @var string|null $loginUrl
 */
$action = $action ?? '#';
$loginUrl = $loginUrl ?? '#';
?>

<section class="flex min-h-[70vh] w-full flex-col items-center justify-center py-12">
    <div class="w-full max-w-xl rounded-3xl border border-slate-200 bg-white p-10 shadow-xl shadow-slate-900/5">
        <div class="flex flex-col items-center text-center">
            <div class="mb-6 h-16 w-16 rounded-2xl bg-emerald-100">
                <span class="sr-only">Logo DonAppetit</span>
                <img src="/donapetit2/public/assets/img/logo-don.png" alt="Logo DonAppetit" class="h-full w-full object-contain" />
            </div>
            <h1 class="text-2xl font-semibold text-slate-900">DonAppetit</h1>
            <p class="mt-1 text-sm text-slate-500">Crear nueva cuenta</p>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($action, ENT_QUOTES, 'UTF-8'); ?>" class="mt-8 space-y-5">
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-slate-700" for="username">Nombre de usuario</label>
                    <input id="username" name="username" type="text" required
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-slate-700" for="email">Email</label>
                    <input id="email" name="email" type="email" required autocomplete="email"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-slate-700" for="password">Contrasena</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                </div>
            </div>

            <div class="border-t border-slate-200 pt-5">
                <h2 class="text-sm font-semibold text-slate-700">Direccion fisica</h2>
                <div class="mt-4 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-slate-700" for="calle">Calle y numero</label>
                        <input id="calle" name="calle" type="text" required
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-slate-700" for="ciudad">Ciudad</label>
                        <input id="ciudad" name="ciudad" type="text" required
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="provincia">Provincia</label>
                        <input id="provincia" name="provincia" type="text" required
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="codigo_postal">Codigo postal</label>
                        <input id="codigo_postal" name="codigo_postal" type="text" required
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    </div>
                </div>
            </div>

            <fieldset class="space-y-3">
                <legend class="text-sm font-semibold text-slate-700">Rol en la plataforma</legend>
                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">
                    <input type="radio" name="rol" value="donante" required class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                    Donante
                </label>
                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">
                    <input type="radio" name="rol" value="receptor" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                    Receptor
                </label>
            </fieldset>

            <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-indigo-500/30 transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400">
                Registrarse
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">
            Ya tienes cuenta?
            <a href="<?php echo htmlspecialchars($loginUrl, ENT_QUOTES, 'UTF-8'); ?>" class="font-semibold text-emerald-600 hover:text-emerald-700">
                Inicia sesion
            </a>
        </p>
    </div>
</section>
