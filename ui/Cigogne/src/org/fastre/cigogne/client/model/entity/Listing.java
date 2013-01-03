package org.fastre.cigogne.client.model.entity;

import java.util.Date;

public class Listing {
	

    /**
     * @var integer $id
     */
    private int id;

    /**
     * @var \DateTime $dateOfBirth
     */
    private Date dateOfBirth;

    /**
     * @var string $name
     */
    private String name;

    /**
     * @var string $description
     */
    private String description;
    
    private String[] codes = new String[10];
    private int cacheCodeIndex = 0;

	/**
	 * @return the id
	 */
	public int getId() {
		return id;
	}

	/**
	 * @param id the id to set
	 */
	public void setId(int id) {
		this.id = id;
	}

	/**
	 * @return the dateOfBirth
	 */
	public Date getDateOfBirth() {
		return dateOfBirth;
	}

	/**
	 * @param dateOfBirth the dateOfBirth to set
	 */
	public void setDateOfBirth(Date dateOfBirth) {
		this.dateOfBirth = dateOfBirth;
	}

	/**
	 * @return the name
	 */
	public String getName() {
		return name;
	}

	/**
	 * @param name the name to set
	 */
	public void setName(String name) {
		this.name = name;
	}

	/**
	 * @return the description
	 */
	public String getDescription() {
		return description;
	}

	/**
	 * @param description the description to set
	 */
	public void setDescription(String description) {
		this.description = description;
	}

	/**
	 * @return the codes
	 */
	public String[] getCodes() {
		return codes;
	}

	/**
	 * @param codes the codes to set
	 */
	public void addCode(String code) {
		this.codes[this.cacheCodeIndex] = code;
		this.cacheCodeIndex++;
	}

	public boolean hasCode(String code) {
		for (int i=0; i < this.codes.length; i++) {
			if (this.codes[i].equalsIgnoreCase(code)) {
				return true;
			}
		}
		return false;
	}


}
