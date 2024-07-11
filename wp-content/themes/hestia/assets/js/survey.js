/**
 * Initialize the formbricks survey.
 * 
 * @see https://github.com/formbricks/setup-examples/tree/main/html
 */
window.addEventListener('themeisle:survey:loaded', function () {
    window?.tsdk_formbricks?.init?.({
        environmentId: "clskegyyx7syhpodwo7llnqg6",
        apiHost: "https://app.formbricks.com",
        ...(window?.hestiaSurveyData ?? {})
    });
}); 