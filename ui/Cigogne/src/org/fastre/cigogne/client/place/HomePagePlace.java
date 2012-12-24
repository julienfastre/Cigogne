package org.fastre.cigogne.client.place;

import com.google.gwt.place.shared.Place;
import com.google.gwt.place.shared.PlaceTokenizer;

public class HomePagePlace extends Place {
	
	private final String token = "home";
	
	public String getToken() {
		return this.token;
	}
	
	
	
	public static class Tokenizer implements PlaceTokenizer<HomePagePlace> {

		@Override
		public HomePagePlace getPlace(String token) {
			return new HomePagePlace();
		}

		@Override
		public String getToken(HomePagePlace place) {
			return place.getToken();
		}
		
	}

}
