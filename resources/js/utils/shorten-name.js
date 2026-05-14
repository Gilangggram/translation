export function shortenName(name) {
    const words = name.trim().split(' ');

    if (words.length <= 2) {
        return name;
    }

    const shortened = words
        .slice(0, -2)
        .map(word => word.charAt(0).toUpperCase() + '.');

    return [...shortened, ...words.slice(-2)].join(' ');
}