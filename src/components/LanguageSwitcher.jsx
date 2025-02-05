import React, { useState } from "react";
import { useLanguage } from "../contexts/LanguageContext";

const LanguageSwitcher = () => {
    const { language, setLanguage } = useLanguage();
    const [isOpen, setIsOpen] = useState(false);

    const toggleDropdown = () => setIsOpen(!isOpen);

    const changeLanguage = (lang) => {
        setLanguage(lang);
        setIsOpen(false);
    };

    return (
        <div className="language-switcher">
            <button className="language-button" onClick={toggleDropdown}>
                {language === "en" ? "🇬🇧 ENG" : "🇷🇸 SRB"}
            </button>
            {isOpen && (
                <ul className="language-dropdown">
                    <li onClick={() => changeLanguage("en")}>🇬🇧 English</li>
                    <li onClick={() => changeLanguage("sr")}>🇷🇸 Srpski</li>
                </ul>
            )}
        </div>
    );
};

export default LanguageSwitcher;
