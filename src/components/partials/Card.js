export default class {
	constructor() {}

	static cardSlideTopLeft() {
		const render = `
            <div
            class="div h-[8em] w-[15em] m-auto rounded-[1em] relative group p-2 z-0 overflow-hidden bg-first text-gray-100 cursor-pointer hover:translate-y-[-5px]"
            >
            <div
                class="h-[7em] w-[7em] bg-[#FDEE00] rounded-full absolute bottom-full -left-[3.5em] group-hover:scale-[550%] z-[-1] duration-[400ms]"
            ></div>
            <div
                class="h-[6em] w-[6em] bg-[#7CFC00] rounded-full absolute bottom-full -left-[3.5em] group-hover:scale-[400%] z-[-1] duration-[400ms]"
            ></div>
            <div
                class="h-[5em] w-[5em] bg-[#007FFF] rounded-full absolute bottom-full -left-[3.5em] group-hover:scale-[300%] z-[-1] duration-[400ms]"
            ></div>

            <button
                class="text-[0.8em] absolute bottom-[1em] left-[1em] text-gray-100 group-hover:text-gray-100 duration-100"
            >
                <span
                class="relative before:h-[0.16em] before:absolute before:w-full before:content-[''] before:bg-[#6C3082] group-hover:before:bg-white duration-100 before:bottom-0 before:left-0"
                >More Info</span
                >
                <i class="fa-solid fa-arrow-right text-gray-100"></i>
            </button>

            <h1
                class="z-20 font-bold font-Poppin text-[1.4em] group-hover:text-gray-100 duration-100"
            >
                HEADING
            </h1>
            </div>
        `;
		return render;
	}

	static cardSlideTopRight() {
		const render = `
            <div
            class="div h-[8em] w-[15em] bg-white m-auto rounded-[1em] relative group p-2 z-0 overflow-hidden bg-first text-gray-100 cursor-pointer hover:translate-y-[-5px]"
            >
            <div
                class="z-[-1] h-full w-[200%] rounded-[1em] bg-gradient-to-br from-[#007FFF] via-[#7CFC00] to-[#FDEE00] absolute bottom-full right-0 group-hover:-rotate-90 group-hover:h-[300%] duration-500 origin-bottom-right"
            ></div>

            <button
                class="text-[0.8em] absolute bottom-[1em] left-[1em] text-[#6C3082] group-hover:text-[white]"
            >
                <span
                class="relative before:h-[0.16em] before:absolute before:w-full before:content-[''] before:bg-[#6C3082] group-hover:before:bg-[white] duration-50 before:bottom-0 before:left-0"
                >More Info</span
                >
                <i class="fa-solid fa-arrow-right"></i>
            </button>

            <h1
                class="z-20 font-bold font-Poppin group-hover:text-white delay-150 text-[1.4em]"
            >
                HEADING
            </h1>
            </div>
        `;
		return render;
	}

	static cardManyBarHorizontal() {
		const render = `
            <div
            class="div h-[8em] w-[15em] bg-white m-auto rounded-[1em] relative group p-2 z-0 overflow-hidden bg-first text-gray-100 cursor-pointer hover:translate-y-[-5px]"
            >
            <div
                class="h-full w-[20%] bg-[#FDEE00] absolute left-0 bottom-full z-[-1] group-hover:translate-y-full duration-[400ms]"
            ></div>
            <div
                class="h-full w-[20%] bg-[#7CFC00] absolute left-[20%] top-full z-[-1] group-hover:-translate-y-full duration-[400ms] delay-[50ms]"
            ></div>
            <div
                class="h-full w-[20%] bg-[#007FFF] absolute left-[40%] bottom-full z-[-1] group-hover:translate-y-full duration-[400ms] delay-[100ms]"
            ></div>
            <div
                class="h-full w-[20%] bg-[#FF5800] absolute left-[60%] top-full z-[-1] group-hover:-translate-y-full duration-[400ms] delay-[150ms]"
            ></div>
            <div
                class="h-full w-[20%] bg-[#FF66CC] absolute left-[80%] bottom-full z-[-1] group-hover:translate-y-full duration-[400ms] delay-[200ms]"
            ></div>

            <button
                class="text-[0.8em] absolute bottom-[1em] left-[1em] text-[#6C3082] group-hover:text-gray-100 duration-100"
            >
                <span
                class="relative before:h-[0.16em] before:absolute before:w-full before:content-[''] before:bg-[#6C3082] group-hover:before:bg-white duration-100 before:bottom-0 before:left-0"
                >More Info</span
                >
                <i class="fa-solid fa-arrow-right"></i>
            </button>

            <h1
                class="z-20 font-bold font-Poppin text-[1.4em] group-hover:text-gray-100 duration-100"
            >
                HEADING
            </h1>
            </div>
        `;
		return render;
	}

	static cardManyBar() {
		const render = `
            <div
            class="h-[8em] w-[15em] bg-white m-auto rounded-[1em] relative group p-2 z-0 overflow-hidden bg-first text-gray-100 cursor-pointer hover:translate-y-[-5px]"
            >
            <div
                class="h-full w-1/5 bg-[#FDEE00] absolute left-0 bottom-full z-[-1] group-hover:translate-y-full duration-500"
            ></div>
            <div
                class="h-1/3 w-full bg-[#FF5800] absolute left-[120%] top-0 z-[-1] group-hover:-translate-x-full duration-500"
            ></div>
            <div
                class="h-1/3 w-full bg-[#007FFF] absolute right-[100%] top-1/3 z-[-1] group-hover:translate-x-full duration-500"
            ></div>
            <div
                class="h-full w-4/5 bg-[#7CFC00] absolute left-[20%] top-full z-[-1] group-hover:-translate-y-[33.3%] duration-500"
            ></div>

            <button
                class="text-[0.8em] absolute bottom-[1em] left-[1em] text-[#6C3082] group-hover:text-gray-100 duration-100"
            >
                <span
                class="relative before:h-[0.16em] before:absolute before:w-full before:content-[''] before:bg-[#6C3082] group-hover:before:bg-white duration-100 before:bottom-0 before:left-0"
                >More Info</span
                >
                <i class="fa-solid fa-arrow-right"></i>
            </button>

            <h1
                class="z-20 font-bold font-Poppin text-[1.4em] group-hover:text-gray-100 delay-100 duration-100"
            >
                HEADING
            </h1>
            </div>
        `;
		return render;
	}
}
