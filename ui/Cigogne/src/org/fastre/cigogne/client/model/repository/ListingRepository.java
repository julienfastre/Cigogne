package org.fastre.cigogne.client.model.repository;

import org.fastre.cigogne.client.model.entity.Listing;

public class ListingRepository {
	
	private Listing cacheListing;
	
	public interface getListingEvent {
		public void onGet(Listing listing);
	}
	
	public void getListingByCode(String code, getListingEvent e) {
		if (this.cacheListing != null) {
			if (this.cacheListing.hasCode(code)) {
				e.onGet(this.cacheListing);
			}
		} else {
			return;
			//TODO make the request to retrieve the list
		}
	}

}
