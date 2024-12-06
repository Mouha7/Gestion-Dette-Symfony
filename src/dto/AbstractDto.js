export default class {
    constructor(headers, datas, limit, page, total) {
        this.headers = headers;
        this.datas = datas;
        this.limit = limit ?? 1;
        this.page = page ?? 10;
        this.total = total;
    }

    getDto() {
        return {
            headers: this.headers,
            datas: this.datas,
            limit: this.limit,
            page: this.page,
            total: this.total,
        }
    }
}